<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        return view("search.index");
    }

    public function query(Request $request)
    {
        $request->validate([
            "query" => "required|min:3|max:100"
        ]);
        $query = strtolower($request->input("query"));
        $items = Items::where("item_name", "ilike", "%$query%")->limit(10)->get();

        return view("search.query",[
            "items" => $items
        ]);
    }
}
