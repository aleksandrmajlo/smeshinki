<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use Illuminate\Http\Request;
use Goutte\Client;


class AnecdoteController extends Controller
{

    public function index()
    {
//        $limit = config('app.limit');
        $limit =12;
        $anecdotes = Anecdote::orderBy('created_at','desc')->paginate($limit);
        meta()
            ->set('title', 'Анекдоти')
            ->set('description', 'Анекдоти');
        $url = env('APP_URL');
        $breadcrumb = [
            [
                'href' => $url,
                'title' => __('site.home')
            ],
            [
                'href' => '',
                'title' => 'Анекдоти'
            ],
        ];
        // рандомный  цвет
        $strJsonFileContents = file_get_contents(public_path()."/colors/color.json");
        $colors=json_decode($strJsonFileContents);
        shuffle($colors);
        return view('anecdotes.index', [
            'anecdotes' => $anecdotes,
            'url' => env('APP_URL'),
            'breadcrumb' => $breadcrumb,
            'colors'=>$colors
        ]);
    }

    public function show(Anecdote $anecdote)
    {
        meta()
            ->set('title', $anecdote->meta_title)
            ->set('description', $anecdote->meta_description);
        $url = env('APP_URL');
        $breadcrumb = [
            [
                'href' => $url,
                'title' => __('site.home')
            ],
            [
                'href' => $url . '/anecdotes',
                'title' => 'Анекдоти'
            ],
            [
                'href' => '',
                'title' => $anecdote->meta_title
            ],
        ];
        return view('anecdotes.show', [
            'anecdote' => $anecdote,
            'url' => $url,
            'breadcrumb' => $breadcrumb
        ]);
    }


    // получить анедот рандом на главной
    public function getAnecdote(Request $request)
    {
        $ids = $request->ids;
        $count=Anecdote::count();
        $new_arr=false;
        if($count==count($ids)){
            $ids=[];
            $new_arr=true;
        }
        $anecdote = Anecdote::inRandomOrder()
            ->whereNotIn('id', $ids)
            ->first();

        return response()->json([
            'anecdote'=>$anecdote,
            'new_arr'=>$new_arr,
        ]);
    }

    // парсер
    public function anecdotes_parser()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 0);

        header('Content-Type: text/html; charset=utf-8');
        $client = new Client();
        $link = "http://anekdot.if.ua/";
        for ($i = 1; $i <= 10000; $i++) {
            if ($i > 1) {
                $link = "http://anekdot.if.ua/page/$i/";
            }
            try {
                sleep(1);

                $crawler = $client->request('GET', $link);
                $crawler->filter('h2 > a')->each(function ($node) {
                    $title = $node->text();
                    $count = Anecdote::where('title', $title)->count();
                    // проверяем на уникальность по названию
                    if ($count == 0) {
                        $href = $node->attr('href');
                        self::saveItem($title, $href);
                    }
                });
            } catch (\InvalidArgumentException $e) {
//                    exit();
            }
        }
    }

    public static function saveItem($title, $href)
    {
        $client = new Client();
        try {
            $crawler = $client->request('GET', $href);
            $entry = $crawler->filter('.entry>p')->eq(0);
            $html = $entry->html();
            $html = preg_replace('#<a.*?>(.*?)</a>#i', '\1', $html);
            $anectode = new Anecdote;
            $anectode->title = $title;
            $anectode->description = $html;
            $anectode->meta_title = $title;
            $anectode->meta_description = $title;
            $anectode->save();

        } catch (\InvalidArgumentException $e) {
//            Log::channel('parser')->info('Сайт не отвечает. ' . $e->getMessage());
        }


    }

    // фото парсер
    public function anecdotes_parser_photo(){

        set_time_limit(0);
        ini_set('max_execution_time', 0);

        header('Content-Type: text/html; charset=utf-8');
        $client = new Client();
        $link = "https://www.westwild.com.ua/2020/02/anekdoty-ukrayinskoyu-movoyu.html?m=1";

        try{
            $crawler = $client->request('GET', $link);
            dd($crawler);
        }catch (\InvalidArgumentException $e){

        }

    }
}
