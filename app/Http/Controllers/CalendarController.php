<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Typecalendar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;


class CalendarController extends Controller
{
    // страница календаря общая
    public function index()
    {
        meta()
            ->set('title', 'Календар')
            ->set('description', 'Календар');
        $sort = session('sort', 'rating');
        $data_type = Typecalendar::all();
        return view('calendar.index', [
            'sort' => $sort,
            'data_type' => $data_type
        ]);
    }

    // страница конкретной даты
    public function show(Calendar $calendar)
    {
        $limit = config('app.limit');
        meta()
            ->set('title', $calendar->meta_title)
            ->set('description', $calendar->meta_description);

        $sort = session('sort', 'rating');
        $holiday_ids=$calendar->holidays->pluck('id')->toArray();
        if ($sort == 'new_end') {
            $posts = Post::orderBy('created_at', 'desc')->active()->whereIn('holiday_id', $holiday_ids)->paginate($limit);
        } elseif ($sort == 'end_new') {
            $posts = Post::orderBy('created_at')->active()->whereIn('holiday_id', $holiday_ids)->paginate($limit);
        } else {
            $posts = Post::orderBy('rating_avg', 'desc')->active()->whereIn('holiday_id', $holiday_ids)->paginate($limit);
        }

        $isFav = [];
        if (Auth::user()) {
            $favs = \DB::table('post_user')
                ->where('user_id', Auth::user()->id)
                ->get('post_id');
            if ($favs) {
                foreach ($favs as $fav) {
                    $isFav[] = $fav->post_id;
                }
            }
        }
        return view('calendar.show', [
            'calendar' => $calendar,
            'posts' => $posts,
            'url' => env('APP_URL'),
            'isFav' => $isFav,
            'sort' => $sort
        ]);
    }

    // установка сортировки
    public function sort(Request $request)
    {
        session(['sort' => $request->sort]);
        return redirect()->back();
    }

    // парсер с календаря
    public function calendar_parser()
    {
        try {
//            $path = public_path() . '/calendar/UkraineHolidays.ics';
            $path = public_path() . '/calendar/ical-ukraine.ics';
            $ical = new \ICal\ICal($path, array(
            ));
            $events=$ical->events();
            foreach ($events as $event){
                if(!is_null($event->dtstamp)){

                    $title=$event->summary;
                    $description=$event->description;
                    $time=(int) $event->dtstart_array[2];
                    $date=Carbon::createFromTimestamp($time)->format('Y-m-d');

                    $count_holiday=Holiday::where('title_orig',$title)->count();
                    if($count_holiday===0){
                        // если нету праздника с таким названием
                        $holiday=new Holiday;
                        $holiday->title=$title;
                        $holiday->title_orig=$title;
                        $holiday->description=$description;
                        $holiday->meta_title=$title;
                        $holiday->meta_description=$title;
                        $holiday->save();
                        //проверим  дату на календаре
                        $calendar=Calendar::where('date',$date)->first();
                        if($calendar){
                          $calendar_id=$calendar->id;
                        }else{
                            // тут еще добавить проверку на повторитель!!!!!!!!1

                            // создадим новую дату
                            $calendar=new Calendar;
                            $calendar->date=$date;
                            $calendar->repeat=1;
                            $calendar->typecalendar_id=3;
                            $calendar->meta_description=$date;
                            $calendar->meta_title=$date;
                            $calendar->save();
                            $calendar_id=$calendar->id;
                        }
                        $holiday->calendars()->attach($calendar_id);
                    }
                }

            }

        } catch (\Exception $e) {
            die($e);
        }
    }
}
