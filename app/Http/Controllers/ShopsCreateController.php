<?php

namespace App\Http\Controllers;

use App\Models\LegalInformation;
use App\OtherAPI\CallPassword;
use App\Models\Cities;
use App\Models\Countries;
use App\Models\Shops;
use App\OtherAPI\FNS;
use App\Rules\CallPasswordRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use MongoDB\Driver\Session;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use PHPUnit\Framework\Constraint\Count;

class ShopsCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::all();
        return view("shops.create", ["countries" => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name_shop" => "required|max:255|unique:shops",
            "description" => "required",
            "phone" => "required|digits:11|unique:shops",
            "email" => "required|email",
            "site" => "nullable|active_url",
            "work_time" => "nullable|max:100",
            "min_price" => "nullable|digits_between:0,1000000",
            "city" => "required|exists:cities,id",
            "logo" => "nullable|image",
            "terms" => "accepted"
        ]);
        $data = [
            "user_id" => $request->user()->id,
            "name_shop" => $request->name_shop,
            "description" => $request->description,
            "phone" => $request->phone,
            "email" => $request->email,
            "site" => $request->site,
            "work_time" => $request->work_time,
            "min_price" => $request->min_price,
            "city_id" => $request->city,
        ];

        $image = $request->file("logo");
        if(!is_null($image))
        {
            $path = $image->store("uploads/logos");
            $data['logo'] = $path;
        }

        $model = Shops::create($data);

        return redirect()->route("phone.activation", $model->id);
    }

    public function phone_activation($shop_id)
    {
        $model = Shops::select(["phone", "phone_active"])->where([
            "id" => $shop_id,
            ])->first();

        if(is_null($model))
            abort(404);

        if($model->phone_active)
            return redirect()->route("shop.show", $shop_id);

        return view("shops.phone-activation", [
            "phone" => $model->phone,
            "shop_id" => $shop_id
        ]);
    }

    public function check_code(Request $request)
    {
        $shop_id = $request->route("shop_id");
        $request->validate([
            "phone_code" => ["required", new CallPasswordRule]
        ]);

        \session()->remove("phone_code");
        Shops::where(["id" => $shop_id, "user_id" => auth()->user()->id])->update(["phone_active" => true]);
        return redirect()->route("shop.show", $shop_id);
    }

    public function resend_code($shop_id)
    {
        $model = Shops::select("phone")->where([
            "id" => $shop_id,
            "phone_active" => false
        ])->first();

        if(is_null($model))
            abort(404);

        if(!CallPassword::makeCall($model->phone))
            abort(503);

        return redirect()->route("phone.activation", $shop_id)->with("message", "Код был отправлен повторно!");
    }

    public function legal_information($shop_id)
    {
        $model = Shops::where([
            "id" => $shop_id,
        ])->first();

        if(is_null($model))
            abort(404);

        $ogrn = (is_null($model->legals_information)) ? null : $model->legals_information->ogrn;

        return view("shops.legal-information", [
            'shop_id' => $shop_id,
            'ogrn' => $ogrn
        ]);
    }

    public function legal_store(Request $request, $shop_id)
    {
        $model = Shops::where([
            "id" => $shop_id,
        ])->first();

        if(is_null($model))
            abort(404);

        $request->validate([
            'ogrn' => 'required|digits_between:10,20',
            'terms' => 'accepted'
        ]);

        if(LegalInformation::where("ogrn", $request->ogrn)->exists())
            return \redirect()->back()->with("message", "Уже существует магазин с данным ОГРН!");

        $response = FNS::getInfo($request->ogrn);

        if(is_null($response))
            return \redirect()->back()->with("message", "Данный ОГРН не числится в базе ФНС");


        $key = array_key_first($response);

        if($response[$key]["Статус"] !== "Действующее")
            return \redirect()->back()->with("message", "Данный ОГРН является не действующим!");

        switch (array_key_first($response))
        {
            case "ИП":
                $fio = explode(' ', $response[$key]["ФИОПолн"]);
                $data = [
                    "ogrn" => $response[$key]["ОГРНИП"],
                    "inn" => $response[$key]["ИННФЛ"],
                    "date_register" => $response[$key]["ДатаОГРН"],
                    "adress" => $response[$key]["Адрес"]["АдресПолн"],
                    "firstname" => $fio[1],
                    "surname" => $fio[0],
                    "middle_name" => $fio[2],
                ];
                break;

            case "ЮЛ":
                $fio = explode(' ', $response[$key]["Руководитель"]["ФИОПолн"]);
                $data = [
                    "ogrn" => $response[$key]["ОГРН"],
                    "inn" => $response[$key]["ИНН"],
                    "kpp" => $response[$key]["КПП"],
                    "date_register" => $response[$key]["ДатаОГРН"],
                    "adress" => $response[$key]["Адрес"]["АдресПолн"],
                    "name" => $response[$key]["НаимПолнЮЛ"],
                    "firstname" => $fio[1],
                    "surname" => $fio[0],
                    "middle_name" => $fio[2],
                ];
                break;
        }

        $data['shop_id'] = $shop_id;

        LegalInformation::create($data);
        return \redirect()->route("shop.show", $shop_id)->with("message", "Добавлена юридическая информация!");
    }
}
