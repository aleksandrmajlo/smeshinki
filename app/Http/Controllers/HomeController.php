<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anecdote;
use App\Models\Post;
use App\Models\Calendar;
use App\Models\Typecalendar;
use App\Models\Word;

class HomeController extends Controller
{
    public function index()
    {
        meta()
            ->set('title', __('site.home'))
            ->set('description', __('site.home_desc'));
        $data_type=Typecalendar::all();
        return view('home', [
            'data_type'=>$data_type
        ]);
    }

    // получить даты календаря
    public function getCalendar(Request $request)
    {
        $typecalendar_=$request->typecalendar;
        $typecalendar=Typecalendar::find($typecalendar_);
        $res = [];
        foreach ($typecalendar->calendars as $calendar) {
            $date = $calendar->date;
            $date_ar = explode('-', $date);
            $res[] = [
                'id' => $calendar->id,
                'year' => $date_ar[0],
                'month' => (int)$date_ar[1] - 1,
                'date' => $date_ar[2],
                'title' => $calendar->title
            ];
        }
        return response()->json($res);
    }

    // получить записи для даного праздника
    public function getPost(Request $request)
    {
        $calendar_id = $request->calendar_id;
        $calendar=Calendar::find($calendar_id);
        $posts = $calendar->limitposts;
        return response()->json([
           'posts'=> $posts,
           'url'=> $calendar->url
        ]);
    }

    // получить анедот
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
            'new_arr'=>$new_arr
        ]);
    }

    // получаем картинки
    public function getWord(Request $request)
    {
        $limit=10;
        return Word::orderBy('id', 'desc')->paginate($limit);

    }
}