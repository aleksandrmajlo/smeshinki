<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeSend;
use App\Models\Welcome;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    public function addWelcome(Request $request){
       $welcome_text=$request->welcome;
        $title=strtok($welcome_text, " ");
        $welcome=new Welcome();
        if(Auth::user()){
            $welcome->user_id=Auth::user()->id;
        }else{
            $welcome->name=$request->name;
            $welcome->email=$request->email;
        }
        $welcome->calendar_id=$request->calendar_id;
        $welcome->title=$title;
        $welcome->welcome=$welcome_text;
        if ($request->photo) {
            $file = $request->file('photo');
            $welcome->photo = self::upload($file);
        }
        $welcome->save();
        // отправка почты
        if($welcome->user){
            $user=$welcome->user->name.' '.$welcome->user->email;
        }else{
            $user=$welcome->name.' '.$welcome->email;
        }
        $link=env('APP_URL').'/admin/welcomes/'.$welcome->id.'/edit';
        \Mail::to(env('MAIL_TO_ADMIN'))->send(new WelcomeSend($user,$link));

        return response()->json(['suc'=>1]);

    }

    public static function upload($file)
    {
        $fileName = "welcome_" . time() . '.' . $file->getClientOriginalExtension();
        $data = getimagesize($file);
        $destinationPath = public_path('/images/uploads');
        $file->move($destinationPath,$fileName);
        $fileBase =  'images/uploads/' . $fileName;
        return $fileBase;
    }

}
