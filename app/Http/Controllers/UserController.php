<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addFav(Request $request){
        $post_id=$request->post_id;
        $user_id=$request->user_id;
        \DB::table('post_user')
             ->insert([
                 ['user_id'=>$user_id,'post_id'=>$post_id]
             ]);
        return response()->json(['suc'=>1]);
    }
    public function delFav(Request $request){
        $post_id=$request->post_id;
        $user_id=$request->user_id;
        \DB::table('post_user')
             ->where('user_id',$user_id)
             ->where('post_id',$post_id)
            ->delete();
        return response()->json(['suc'=>1]);
    }
}
