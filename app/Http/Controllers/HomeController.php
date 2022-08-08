<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Anecdote;
use App\Models\Post;
use App\Models\Holiday;
use App\Models\Calendar;
use App\Models\Typecalendar;
use App\Models\Word;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    // главная
    public function index()
    {
        meta()
            ->set('title', __('site.home'))
            ->set('description', __('site.home_desc'));
        $data_type=Typecalendar::all();
        return view('index', [
            'data_type'=>$data_type
        ]);
    }
    // домашняя страница
    public function home(){
        if(Auth::user()){
            meta()
                ->set('title','Вибране')
                ->set('description','Вибране');
            $isFav = [];
            $favs = \DB::table('post_user')
                ->where('user_id', Auth::user()->id)
                ->get('post_id');
            if ($favs) {
                foreach ($favs as $fav) {
                    $isFav[] = $fav->post_id;
                }
            }
            $sort=  session('sort','rating');
            if($sort=='new_end'){
                $posts=Post::orderBy('created_at','desc')->whereIn('id', $isFav)->get();
            }elseif($sort=='end_new'){
                $posts=Post::orderBy('created_at')->whereIn('id', $isFav)->get();
            }
            else{
                $posts=Post::orderBy('rating_avg','desc')->whereIn('id', $isFav)->get();
            }
            return view('home',[
                'posts' => $posts,
                'url' => env('APP_URL'),
                'sort'=>$sort,
                'isFav' => $isFav,
                'linkCatalog'=>1
            ]);
        }else{
            return abort('403');
        }


    }

    // получить даты календаря
    public function getCalendar(Request $request)
    {
//        $typecalendar_=$request->typecalendar;
//        $typecalendar=Typecalendar::find($typecalendar_);
        $calendars=Calendar::all();
        $res = [];
        foreach ($calendars as $calendar) {
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
        $typecalendar=(int)$request->typecalendar;
        $calendar=Calendar::find($calendar_id);
        $holidays = $calendar->holidays;
        $posts=collect();
        foreach ($holidays as $holiday){
            if($holiday->typecalendar->id==$typecalendar){
                foreach ($holiday->posts as $item){
                    $posts->push($item);
                }
            }
        }
        return response()->json([
            'holidays'=>$holidays,
           'posts'=> $posts,
           'url'=> $calendar->url
        ]);
    }

    // получить записи для данного дня
    public function getPostToday(Request $request){

       $typecalendar=(int)$request->typecalendar;
       $date=$request->date;
       $holidays=collect();
       $posts=collect();
       $url='';
       $calendar=Calendar::whereDate('date', $date)
                           ->first();

       if($calendar){
           $holidays = $calendar->holidays;
           $url=$calendar->url;
           foreach ($holidays as $holiday){
               if($holiday->typecalendar->id==$typecalendar){
                   foreach ($holiday->posts as $item){
                       $posts->push($item);
                   }
               }

           }
       }
        return response()->json([
            'holidays'=>$holidays,
            'posts'=> $posts,
            'url'=> $url
        ]);
    }
}
