<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
   public function addRating(Request $request){

       $post_id=$request->post_id;
       $rating=$request->rating;
       $post=Post::find($post_id);
       //
       $total_rating=$post->total_rating+$rating;
       $total_votes=$post->total_votes+1;
       $rating_avg=(float)$total_rating/$total_votes;

       $post->total_rating=$total_rating;
       $post->total_votes=$total_votes;
       $post->rating_avg=$rating_avg;
       $post->save();
       return response()->json([
           'total_votes'=>$total_votes,
           'rating_avg'=>$rating_avg,
       ]);
   }
}
