<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Items;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function LandingPage()
    {
        $orders = Attachments::where("type", "item")->latest()->limit(9)->get();
        $items = Items::latest()->limit(9)->get();

        return view("landing", [
            "orders" => $orders,
            "items" => $items,
        ]);
    }
}
