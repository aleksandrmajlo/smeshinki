<?php


namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;


class TelegramService
{

    // отправка двух сообщений
    public static function send2Telegram($id, $msg, $token = '5260107662:AAGfaQ75QGqLZYetJRCTuiLkGQT6YvK6lNA') {
        $data = array(
            'chat_id' => $id,
            'text' => $msg,
            'parse_mode' =>'HTML' ,
        );
        if($token != '') {
            $ch = curl_init('https://api.telegram.org/bot'.$token.'/sendMessage');
            curl_setopt_array($ch, array(
                CURLOPT_HEADER => 0,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data
            ));
            curl_exec($ch);
            curl_close($ch);
        }
    }

    // Записать что получили метод
    public static function putLogIn($data)
    {
        file_put_contents(public_path() . "/log_my/tel_values.txt", $data . "\n", FILE_APPEND);
    }

    // Записать еще что нибуть
    public static function othnerLogIn($data)
    {
        file_put_contents(public_path() . "/log_my/tel_values.txt", implode(',', $data) . "\n", FILE_APPEND);
    }



}
