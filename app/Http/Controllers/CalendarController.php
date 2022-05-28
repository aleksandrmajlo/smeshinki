<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Typecalendar;
use Illuminate\Http\Request;
use App\Models\Calendar;
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
        $data_type=Typecalendar::all();
        return view('calendar.index', [
            'sort' => $sort,
            'data_type'=>$data_type
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
        if ($sort == 'new_end') {
            $posts = Post::orderBy('created_at', 'desc')->active()->where('calendar_id', $calendar->id)->paginate($limit);
        } elseif ($sort == 'end_new') {
            $posts = Post::orderBy('created_at')->active()->where('calendar_id', $calendar->id)->paginate($limit);
        } else {
            $posts = Post::orderBy('rating_avg', 'desc')->active()->where('calendar_id', $calendar->id)->paginate($limit);
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
}
