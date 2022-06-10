<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // получить записи на странице  календаря
    public function getPosts()
    {
        $limit = config('app.limit');
        $sort=  session('sort','rating');


        if($sort=='new_end'){
            return Post::orderBy('created_at','desc')->active()->paginate($limit);
        }elseif($sort=='end_new'){
            return Post::orderBy('created_at')->active()->paginate($limit);
        }
        else{
            return Post::orderBy('rating_avg','desc')->active()->paginate($limit);
        }

    }
    // получить пользователя на странице календаря
    // и фаворитлв
    public function getUser(){
        $isFav = [];
        $user_id=false;
        if (Auth::user()) {
            $user_id=Auth::user()->id;
            $favs = \DB::table('post_user')
                ->where('user_id', Auth::user()->id)
                ->get('post_id');
            if ($favs) {
                foreach ($favs as $fav) {
                    $isFav[] = $fav->post_id;
                }
            }
        }
        $calendars=Calendar::all();
        $collect_calendars=collect();
        foreach ($calendars as $calendar){
            $collect_calendars->push(
                [
                    'id'=>$calendar->id,
                    'title'=>$calendar->title,
                    'date'=>$calendar->date,
                    'url'=>$calendar->url,
                    'date_write'=>$calendar->date_write,
                ]
            );
        }
        return response()->json([
            'isFav'=>$isFav,
            'user_id'=>$user_id,
            'calendars'=>$collect_calendars
        ]);
    }
    /*
     * рейтинг
     */
    public function addRating(Request $request)
    {
        $post_id = $request->post_id;
        $rating = $request->rating;
        $post = Post::find($post_id);
        //
        $total_rating = $post->total_rating + $rating;
        $total_votes = $post->total_votes + 1;
        $rating_avg = (float)$total_rating / $total_votes;

        $post->total_rating = $total_rating;
        $post->total_votes = $total_votes;
        $post->rating_avg = $rating_avg;
        $post->save();
        return response()->json([
            'total_votes' => $total_votes,
            'rating_avg' => $rating_avg,
        ]);
    }
}
