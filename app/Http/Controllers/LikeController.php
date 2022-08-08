<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Word;
use App\Models\Anecdote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LikeController extends Controller
{


    /*
   * рейтинг
   */
    public function addRating(Request $request)
    {
        $user_id=null;
        if (Auth::user()) {
            $user_id = Auth::user()->id;
        }

        $post_id = $request->post_id;
        $rating = $request->rating;
        $post_type=$request->post_type;

        if($post_type=='word'){
            $post = Word::find($post_id);
        }elseif ($post_type=='post'){
            $post = Post::find($post_id);
        }elseif ($post_type=='anecdote'){
            $post = Anecdote::find($post_id);
        }else{
            return response()->json([]);
        }
        //
        $total_rating = $post->total_rating + $rating;
        $total_votes = $post->total_votes + 1;
        $rating_avg = (float)$total_rating / $total_votes;

        //'сумма оценок'
        $post->total_rating = $total_rating;
        //'количество оценок'
        $post->total_votes = $total_votes;
        //'средняя оценка' - по ней сортировка
        $post->rating_avg = $rating_avg;
        $post->save();

        // добавляем счетчик
        $alllikes=1;
        $like=\DB::table('count_likes')
            ->where('post_type',$post_type)
            ->where('post_id',$post_id)
            ->where('like',$rating)
            ->first();

        if($like){
            $alllikes=($like->count)+1;
            \DB::table('count_likes')
                ->where('post_type',$post_type)
                ->where('post_id',$post_id)
                ->where('like',$rating)
                ->update(['count' => $alllikes]);

        }else{
            \DB::table('count_likes')->insert([
                'post_type' => $post_type,
                'post_id' => $post_id,
                'like'=>$rating,
                'count' => $alllikes,
                'user_id'=>$user_id
            ]);
        }

        $myRating=0;// типа  без меня
        return response()->json([
            'total_votes' => $total_votes-$myRating,
            'rating_avg' => $rating_avg,
            'alllikes'=>$alllikes, // кол-во оценок  этого рейтинга
            'likes'=>$post->likes
        ]);
    }
    // получить
   //это не работает !!!!!!!!!
    public function getLike(Request $request){
        $post_type=$request->post_type;
        $post_id=$request->post_id;
        $alllikes=0;
        $like=\DB::table('likes')
                   ->where('post_type',$post_type)
                   ->where('post_id',$post_id)
                   ->first();
        if($like){
            $alllikes=$like->like;
        }
        return response()->json([
            'alllikes'=>$alllikes
        ]);
    }

    //  добавить
    //это не работает !!!!!!!!!
    public function addLike(Request $request){
        $post_type=$request->post_type;
        $post_id=$request->post_id;
        $alllikes=1;
        $like=\DB::table('likes')
            ->where('post_type',$post_type)
            ->where('post_id',$post_id)
            ->first();

        if($like){
            $alllikes=($like->like)+1;
            \DB::table('likes')
                ->where('post_type',$post_type)
                ->where('post_id',$post_id)
                ->update(['like' => $alllikes]);

        }else{
            \DB::table('likes')->insert([
                'post_type' => $post_type,
                'post_id' => $post_id,
                'like' => $alllikes,
            ]);
        }

        return response()->json([
            'alllikes'=>$alllikes
        ]);

    }
}
