<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Holiday;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    public function show(Holiday $holiday){

        $limit = config('app.limit');
        meta()
            ->set('title', $holiday->meta_title)
            ->set('description', $holiday->meta_description);

        $sort = session('sort', 'rating');
        $holiday_ids=$holiday->pluck('id')->toArray();
        if ($sort == 'new_end') {
            $posts = Post::orderBy('created_at', 'desc')->active()->where('holiday_id', $holiday->id)->paginate($limit);
        } elseif ($sort == 'end_new') {
            $posts = Post::orderBy('created_at')->active()->where('holiday_id', $holiday->id)->paginate($limit);
        } else {
            $posts = Post::orderBy('rating_avg', 'desc')->active()->where('holiday_id', $holiday->id)->paginate($limit);
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
        return view('holiday.show', [
            'holiday' => $holiday,
            'posts' => $posts,
            'url' => env('APP_URL'),
            'isFav' => $isFav,
            'sort' => $sort
        ]);
    }
}
