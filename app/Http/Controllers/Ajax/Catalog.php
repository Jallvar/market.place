<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Items;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Catalog extends Controller
{
    public function filter(Request $request)
    {
        if(!$request->exists("category_id") || !$request->exists("city_id") || !$request->exists("delivery_id") || !$request->exists("min_price") || !$request->exists("max_price"))
            abort(404);

        $model = Items::where("category_id", $request->category_id);
        if($request->delivery_id > 0)
        {
            Session::put("catalog.delivery_id", $request->delivery_id);
            $model->whereHas("shop.deliveries", function($query) use ($request){
                $query->where("deliveries_id", $request->delivery_id);
            });
        }
        if($request->city_id > 0)
        {
            Session::put("catalog.city_id", $request->city_id);
            $model->whereHas("shop", function($query) use ($request){
                $query->where("city_id", $request->city_id);
            })->get();
        }

        if($request->min_price > 0)
        {
            Session::put("catalog.min_price", $request->min_price);
            $model->where("price", ">=", $request->min_price);
        }

        if($request->max_price > 0)
        {
            Session::put("catalog.max_price", $request->max_price);
            $model->where("price", "<=", $request->max_price);
        }
        $items = $model->get();

        return view("catalog.category-list", [
            "items" => $items
        ]);
    }
}
