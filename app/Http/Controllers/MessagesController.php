<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Items;
use App\Models\Messages;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    public function index()
    {
        $model = Messages::select("*")
            ->distinct("user_from_id")
            ->where("user_to_id", auth()->user()->id)
            ->with(["attachments", "user_to", "user_from"])
            ->get();

        return view("messages.index", [
            "messages" => $model
        ]);
    }

    public function show($user_id)
    {
        $model = Messages::where("user_to_id", $user_id)
            ->where("user_from_id", auth()->user()->id)
            ->orWhere("user_to_id", auth()->user()->id)
            ->where("user_from_id", $user_id)
            ->limit(25)
            ->orderBy("id", "desc")
            ->with(["attachments", "user_to", "user_from"])
            ->get()
            ->reverse();


        return view("messages.show", [
            "user_id" => $user_id,
           "messages" => $model,
        ]);
    }

    public function store (Request $request, $user_id)
    {
        $request->validate([
            "message" => "required|max:2000",
            "attachments.*" => "nullable|mimes:jpeg,png,gif,docx,xlsx,ppsx",
        ]);

        $attachments = [];
        //Перебираем присылаемые изображения
        if($request->hasFile('attachments'))
        {
            foreach ($request->file('attachments') as $file) {
                //Сохраняем файл и записываем имя в бд
                $attachments[] = Attachments::create([
                    "value" => $file->store("messages/user_".auth()->user()->id),
                    "type" => $this->getTypeFile($file),
                    "user_id" => auth()->user()->id,
                ])->id;
            }
        }

        $model = Messages::Create([
            "message" => $request->message,
            "user_from_id" => auth()->user()->id,
            "user_to_id" => $user_id
        ]);

        $model->attachments()->attach($attachments);
        return redirect()->route("messages.show", $user_id);
    }

    public function order($item_id)
    {
        $model = Items::with("cover")->find($item_id);
        Session::put("item_id", $item_id);

        return view("messages.order", [
            "item_id" => $item_id,
            "item_name" => $model->item_name,
            "description" => $model->description,
            "cover" => $model->cover->value,
        ]);
    }

    public function storeOrder (Request $request)
    {
        $request->validate([
            "item_id" => "required|exists:items,id",
            "message" => "required|max:2000",
            "attachments.*" => "nullable|mimes:jpeg,png,gif,docx,xlsx,ppsx",
        ]);

        $attachments = [];
        //Перебираем присылаемые изображения
        if($request->hasFile('attachments'))
        {
            foreach ($request->file('attachments') as $file) {
                //Сохраняем файл и записываем имя в бд
                $attachments[] = Attachments::create([
                    "value" => $file->store("messages/user_".auth()->user()->id),
                    "type" => $this->getTypeFile($file),
                    "user_id" => auth()->user()->id,
                ])->id;
            }
        }

        $attachments[] = Attachments::Create([
            "value" => $request->item_id,
            "type" => "item",
            "user_id" => auth()->user()->id,
        ])->id;

        $model = Messages::Create([
            "message" => $request->message,
            "user_from_id" => auth()->user()->id,
            "user_to_id" => Items::find($request->item_id)->Shop->user_id
        ]);

        $model->attachments()->attach($attachments);
        return redirect()->route("messages.show", $model->user_to_id);
    }

    private function getTypeFile($file)
    {
        $type = $file->getClientOriginalExtension();
        switch ($type)
        {
            case  "png":
            case  "gif":
            case "jpg":
            case "jpeg":
                return "image";
                break;

            case "docx":
            case "xlsx":
            case "ppsx":
                return $type;
                break;
        }
    }

}
