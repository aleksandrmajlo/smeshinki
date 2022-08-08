<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;
use Azate\LaravelTelegramLoginAuth\TelegramLoginAuth;
use Socialite;
use Exception;

class TelegramController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('telegram')->redirect();
    }

   public function callbackFromTelegram(TelegramLoginAuth $telegramLoginAuth, Request $request){
//       if ($user = $telegramLoginAuth->validate($request)) {

//       }

       $request = file_get_contents("php://input");
       $request_test = 22222222222;
       TelegramService::putLogIn2($request);
       TelegramService::putLogIn2($request_test);
       return 'ok';
//       $response=json_encode($request);
//       $first_name = htmlspecialchars($tg_user['first_name']);
//       $last_name = htmlspecialchars($tg_user['last_name']);
//       dump($response);

   }
}
