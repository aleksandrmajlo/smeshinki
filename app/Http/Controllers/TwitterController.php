<?php

namespace App\Http\Controllers;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Models\Word;
use Illuminate\Http\Request;


class TwitterController extends Controller
{
    //
    public function export()
    {
        ini_set('memory_limit', '2048M');
        $config = config('twitter');
        $connection = new TwitterOAuth($config['consumer_key'], $config['consumer_secret'], $config['access_token'], $config['access_token_secret']);
        $words = Word::where('twitter_send', 0)
                       ->whereNotNull('photo')
                       ->limit(50)->get();
        if ($words->isNotEmpty()) {
            foreach ($words as $word) {
                try {
                    $patch = public_path($word->photo);
                    $media = $connection->upload('media/upload', ['media' => $patch]);
                    $parameters = [
                        'status' => '',
                        'media_ids' => $media->media_id_string
                    ];
                    $result = $connection->post('statuses/update', $parameters);
                    if ($connection->getLastHttpCode() == 200) {
                        echo "Your Tweet posted successfully.";
                    } else {
                        echo 'error: ' . $result->errors[0]->message;
                        if($result->errors[0]->message=='User is over daily status update limit.'){
                            break;
                        }
                    }
                } catch (Exception $e) {

                } finally {
                    $word->twitter_send = 1;
                    $word->save();
                }

            }
        }
    }
}
