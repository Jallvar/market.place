<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Categories;
use App\Models\Items;
use App\Models\Shops;
use Cron\Tests\AbstractFieldTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemsController extends Controller
{
    public function show($item_id)
    {
        //DB::enableQueryLog();
        $model = Items::with(["attachments" => function($query){
            $query->where("attachments.type", "image");
        }])->find($item_id);
        //dd(DB::getQueryLog());
        return view("items.show", [
            "item_id" => $item_id,
            "item_name" => $model->item_name,
            "description" => $model->description,
            "price" => $model->price,
            "cover" => $model->cover,
            "quantity" => $model->quantity,
            "shop" => $model->shop,
            "deliveries" => $model->shop->deliveries,
            "category" => $model->category->name,
            "city" => $model->shop->city->name,
            "country" => $model->shop->city->country->name,
            "attachments" => $model->attachments
        ]);
    }

    public function create($shop_id)
    {
        if(!Shops::where("id", $shop_id)->exists())
            return abort(404);

        $categories = Categories::where("categories_id", 0)->with("children")->get();

        return view("items.create", [
            "shop_id" => $shop_id,
            "categories" => $categories
        ]);
    }

    public function store(Request $request, $shop_id)
    {
        $request->validate([
            "item_name" => "required|max:255",
            "description" => "required",
            "category_id" => "required|numeric|exists:categories,id",
            "attachments" => "required",
            "attachments.*" => "image|mimes:jpeg,png,gif|size:3072",
            "price" => "required|numeric",
            "quantity" => "required|numeric"
        ]);
        $attachments = [];
        //Перебираем присылаемые изображения
        if($request->hasFile('attachments'))
        {
            foreach ($request->file('attachments') as $file) {
                //Сохраняем файл и записываем имя в бд
                $attachment = Attachments::create([
                    "value" => $file->store("items/items_".$shop_id),
                    "type" => "image",
                    "user_id" => auth()->user()->id,
                ]);
                //Формируем список для pivot таблицы
                $attachments[] = $attachment->id;
            }
        }

        //Создаем запись в бд. в качестве обложки используем 1 изображение
        $model = Items::create([
            "item_name" => $request->item_name,
            "description" => $request->description,
            "category_id" => $request->category_id,
            "cover_id" => $attachments[0],
            "price" => $request->price,
            "quantity" => $request->quantity,
            "shop_id" => $shop_id,
        ]);
        //Записываем в pivot таблицы прикрепленные изображения
        $model->attachments()->attach($attachments);

        return redirect()->route("shop.show", $shop_id);

    }

    public function edit($item_id)
    {
        $model = Items::with("attachments")->where(["id" => $item_id])->whereHas("shop", function($query) {
            $query->where("user_id", auth()->user()->id);
        })->first();

        if(!$model) abort(404);

        $categories = Categories::where("categories_id", 0)->with("children")->get();
        return view("items.edit", [
            "item_id" => $model->id,
            "item_name" => $model->item_name,
            "description" => $model->description,
            "category_id" => $model->category_id,
            "price" => $model->price,
            "quantity" => $model->quantity,
            "categories" => $categories,
            "attachments" => $model->attachments
        ]);
    }

    public function update(Request $request, $item_id)
    {
        $model = Items::where(["id" => $item_id])->whereHas("shop", function($query) {
            $query->where("user_id", auth()->user()->id);
        })->first();

        if(!$model) abort(404);

        $request->validate([
            "item_name" => "required|max:255",
            "description" => "required",
            "category_id" => "required|numeric|exists:categories,id",
            "attachments.*" => "image|mimes:jpeg,png,gif|size:3072",
            "price" => "required|numeric",
            "quantity" => "required|numeric"
        ]);

        $attachments = [];
        //Перебираем присылаемые изображения
        if($request->hasFile('attachments'))
        {
            foreach ($request->file('attachments') as $file) {
                //Сохраняем файл и записываем имя в бд
                $attachment = Attachments::create([
                    "value" => $file->store("items/items_".$model->shop_id),
                    "type" => "image",
                    "user_id" => auth()->user()->id,
                ]);
                //Формируем список для pivot таблицы
                $attachments[] = $attachment->id;
            }
        }

        $model->attachments()->attach($attachments);

        $model->item_name = $request->item_name;
        $model->description = $request->description;
        $model->category_id = $request->category_id;
        $model->price = $request->price;
        $model->quantity = $request->quantity;
        $model->save();

        return redirect()->route("item.show", $model->id);

    }
}
