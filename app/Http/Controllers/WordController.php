<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
class WordController extends Controller
{
    public function get()
    {
        $url = 'https://www.ukr.net/news/dat/world/1/';
        $url = 'https://www.ukr.net/ua/news/world.html';
//        $url = 'https://www.ukrlib.com.ua/';


        $response = \Curl::to($url)
            ->get();
//        dd($response);



        $client = new Client();
        $body = $client->get($url, [
//            'proxy'   => 'tcp://localhost:80',
            'headers' => [
                'User-Agent' => 'PostmanRuntime/7.29.0',
                'Accept' => '*/*',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Cache-control' => 'no-cache',
                'Connection' => 'keep-alive',
                'X-Foo' => 'Bar',
//                'Host'=>'',
//                'Cookie' => '__cf_bm=eA89weZpG50FU5f4nphKA6F96mbs23ssja91tZVRn3I-1651171679-0-AT/iW5B2hT0sE7fkiyLESkuLmZ5HekJfVImlgSca34xQlit/DYcnkkLaSgxN4yKLCKoJ7eoWkenetGhT5oY0kmo=; scr=9; sfr=9; snr=9; uid=Cj1tBGJq4V+NoBDeC5bSAg==; un_lang=ua; un_news_region=9'

            ],
            'stream' => true,
            'read_timeout' => 2,
            'allow_redirects' => [
                'max'             => 10,        // allow at most 10 redirects.
                'strict'          => true,      // use "strict" RFC compliant redirects.
                'referer'         => true,      // add a Referer header
                'protocols'       => ['https'], // only allow https URLs
//                'on_redirect'     => $onRedirect,
                'track_redirects' => true
            ]
        ])->getBody();
//        $response = json_decode($body);
        dd($body);
    }
}
