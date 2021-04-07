<?php


namespace App\OtherAPI;


use Illuminate\Support\Facades\Http;

class FNS
{
    public static $END_POINT = "https://api-fns.ru/api/egr";

    public static function getInfo($ogrn)
    {
        $params = [
            "req" => $ogrn,
            "key" => \Illuminate\Support\Facades\Config::get("api.fns_key"),
        ];
        $url = FNS::$END_POINT.'?'.http_build_query($params);

        $respones = Http::get($url);

        $response = $respones->json();
        if(is_null($response))
            abort(503);

        return ($response) ? $response['items'][0] : null;

    }
}
