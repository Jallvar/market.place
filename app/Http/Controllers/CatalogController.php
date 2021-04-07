<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Countries;
use App\Models\Deliveries;
use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CatalogController extends Controller
{
    public function index()
    {
        $model = Categories::select(["id", "name"])->with("children")->where("categories_id", 0)->get();
        return view("catalog.index", [
            "categories" => $model
        ]);
    }

    public function category($category_id)
    {
        //dd(Session::all());
        $category = Categories::select("name")->find($category_id);
        $countries = Countries::all();
        $deliveries = Deliveries::all();
        $price_max = Items::where("category_id", $category_id)->max("price");
        $price_min = Items::where("category_id", $category_id)->min("price");

        if(!$category)
            abort(404);

        $model = Items::where("category_id", $category_id);

        if(Session::has("catalog.min_price"))
        {
            $model->where("price", ">=", Session::get("catalog.min_price"));
        }

        if(Session::has("catalog.max_price"))
        {
            $model->where("price", "<=", Session::get("catalog.max_price"));
        }

        if(Session::has("catalog.delivery_id"))
        {
            $model->whereHas("deliveries", function($query){
                $query->where("delivery_id", Session::get("catalog.delivery_id"));
            });
        }
        if(Session::has("catalog.city_id"))
        {
            $model->whereHas("shop", function($query){
                $query->where("city_id", Session::get("catalog.city_id"));
            });
        }

        return view("catalog.category", [
            "items" => $model->get(),
            "category_id"=> $category_id,
            "category_name" => $category->category_name,
            "countries" => $countries,
            "deliveries" => $deliveries,
            "price_max" => $price_max,
            "price_min" => $price_min
        ]);
    }

    public function reset()
    {
        Session::forget("catalog");
        return redirect()->back();
    }
}
