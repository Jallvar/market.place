<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Shops;
use App\Rules\ShopEditRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopsController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($shop_id)
    {
        $model = Shops::where("id", $shop_id)->with(["legal_information", "items", "items.cover"])->first();

        if(is_null($model))
            abort(404);
        elseif($model->active == false && !auth()->check())
            abort(404);
        elseif($model->active == false && $model->user_id !== auth()->user()->id)
            abort(404);

        return view("shops.show", [
            "shop_id" => $model->id,
            "title" => $model->name_shop,
            "description" => $model->description,
            "site" => $model->site,
            "country" => $model->city->country->name,
            "city" => $model->city->name,
            "work_time" => $model->work_time,
            "min_price" => $model->min_price,
            "legal_information" => $model->legal_information,
            "phone_active" => $model->phone_active,
            "active" => $model->active,
            "is_owner" => $model->is_owner,
            "items" => $model->items()->with("category")->paginate(10)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($shop_id)
    {
        $model = Shops::where("id", $shop_id)->first();
        $countries = Countries::all();

        return view("shops.edit", [
            "shop_id" => $model->id,
            "name_shop" => $model->name_shop,
            "description" => $model->description,
            "site" => $model->site,
            "country" => $model->city->country->name,
            "city" => $model->city->id,
            "work_time" => $model->work_time,
            "min_price" => $model->min_price,
            "legal_information" => $model->legal_information,
            "phone" => $model->phone,
            "email" => $model->email,
            "logo" => $model->logo,
            "countries" => $countries
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $shop_id)
    {
        $request->validate([
            "name_shop" => ["required", "max:255", new ShopEditRule()],
            "description" => "required",
            "phone" => ["required", "digits:11", new ShopEditRule()],
            "email" => ["required", "email", new ShopEditRule()],
            "site" => "nullable|active_url",
            "work_time" => "nullable|max:100",
            "min_price" => "nullable|digits_between:0,1000000",
            "city" => "required|exists:cities,id",
            "logo" => "nullable|image",
            "terms" => "accepted"
        ]);

        $model = Shops::where("id", $shop_id)->first();
        $model->name_shop = $request->name_shop;
        $model->description = $request->description;
        $model->email = $request->email;
        $model->site = $request->site;
        $model->work_time = $request->work_time;
        $model->min_price = $request->min_price;
        $model->city_id = $request->city;
        $model->active = false;

        if($model->phone !== $request->phone) {
            $model->phone = $request->phone;
            $model->phone_active = false;
        }

        $image = $request->file("logo");
        if(!$image)
        {
            $path = $image->store("uploads/logos");
            $data['logo'] = $path;
            if($model->logo)
                Storage::delete($model->logo);
        }

        $model->save();

        return (redirect()->route("shop.show", $shop_id));
    }
}
