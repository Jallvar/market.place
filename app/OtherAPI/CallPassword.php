<?php


namespace App\OtherAPI;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use League\Flysystem\Config;

class CallPassword
{
    /*
     *
     */

    public static $END_POINT = "https://smsc.ru/sys/send.php";

    public static function makeCall($phone)
    {
        $params = [
            "login" => \Illuminate\Support\Facades\Config::get("api.cp_login"),
            "psw" => \Illuminate\Support\Facades\Config::get("api.cp_password"),
            "phones" => $phone,
            "mes" => "code",
            "call" => 1,
            "fmt" => 3
        ];
        $url = CallPassword::$END_POINT.'?'.http_build_query($params);
        $respones = Http::get($url);
        $response = $respones->json();
        if(isset($response["error"]))
            return false;

        session()->put("phone_code", $response['code']);
        return true;
    }
}
