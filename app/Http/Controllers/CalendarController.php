<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
class CalendarController extends Controller
{
    public function show(Calendar $calendar){
        $limit=12;
        meta()
            ->set('title',$calendar->meta_title)
            ->set('description',$calendar->meta_description);

        $posts=$calendar->posts()->paginate($limit);

        return view('calendar.show',[
            'calendar'=>$calendar,
            'posts'=>$posts,
            'url'=>env('APP_URL')
        ]);
    }
}
