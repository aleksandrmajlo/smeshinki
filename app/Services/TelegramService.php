<?php


namespace App\Services;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;


class TelegramService
{
    public static function createWordWithPhoto($datas)
    {
        $TELEGRAM_BOT_TOKEN = env('TELEGRAM_BOT_TOKEN');

        $index=count($datas->photo)-1;
        $file_id = $datas->photo[$index]['file_id'];
        $telegram_link = 'https://api.telegram.org/bot' . $TELEGRAM_BOT_TOKEN . '/getFile?file_id=' . $file_id;

        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $telegram_link,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);

        $answer = json_decode($result);
        if ($answer->ok) {
            $time=time();
            $photo_link = 'https://api.telegram.org/file/bot' . $TELEGRAM_BOT_TOKEN . '/' . $answer->result->file_path;
            $ext = pathinfo($photo_link, PATHINFO_EXTENSION);
            if (file_put_contents(public_path() . '/images/uploads/'.$time.'.'.$ext, file_get_contents($photo_link))) {
//                $desc='';
//                if($datas->caption){
//                    $desc=$datas->caption;
//                }
                $word = new Word;
                $word->photo='images/uploads/'.$time.'.'.$ext;
                $word->title='Telegram '.$datas->message_id;
//                $word->description=$desc;
//                $word->show_title=1;
                $word->meta_title='Telegram '.$datas->message_id;
                $word->meta_description='Telegram '.$datas->message_id;
                $word->save();
            }
        }
    }

    // видео
    public static function createWordWithVideo($datas){
        $TELEGRAM_BOT_TOKEN = env('TELEGRAM_BOT_TOKEN');
        $file_id=$datas->video->file_id;
        $file_name=$datas->video->file_name;
        $telegram_link = 'https://api.telegram.org/bot' . $TELEGRAM_BOT_TOKEN . '/getFile?file_id=' . $file_id;

        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $telegram_link,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        $answer = json_decode($result);
        if ($answer->ok) {

            $video_link = 'https://api.telegram.org/file/bot' . $TELEGRAM_BOT_TOKEN . '/' . $answer->result->file_path;
            $ext = pathinfo($video_link, PATHINFO_EXTENSION);
            if (file_put_contents(public_path() . '/files/uploads/'.$file_name, file_get_contents($video_link))) {

                $word = new Word;
                $word->video='files/uploads/'.$file_name;
                $word->title='Telegram '.$datas->message_id;
//                $word->description=$desc;
//                $word->show_title=1;
                $word->meta_title='Telegram '.$datas->message_id;
                $word->meta_description='Telegram '.$datas->message_id;
                $word->save();
            }
        }
    }

    public static function createWordWithText($datas)
    {
        $word = new Word;
        $word->title='Telegram '.$datas->message_id;
        $word->description=$datas->text;
        $word->show_title=1;
        $word->meta_title='Telegram '.$datas->message_id;
        $word->meta_description='Telegram '.$datas->message_id;
        $word->save();
    }

    // отправка двух сообщений НЕ НАДО НО ПУСТЬ БУДЕТ
    public static function send2Telegram($id, $msg, $token = '5260107662:AAGfaQ75QGqLZYetJRCTuiLkGQT6YvK6lNA')
    {
        $data = array(
            'chat_id' => $id,
            'text' => $msg,
            'parse_mode' => 'HTML',
        );
        if ($token != '') {
            $ch = curl_init('https://api.telegram.org/bot' . $token . '/sendMessage');
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
    // Записать  при логине
    public static function putLogIn2($data)
    {
        file_put_contents(public_path() . "/log_my/tel_values2.txt", $data . "\n", FILE_APPEND);
    }

    // Записать еще что нибуть
    public static function othnerLogIn($data)
    {
        file_put_contents(public_path() . "/log_my/tel_values.txt", implode(',', $data) . "\n", FILE_APPEND);
    }


}
