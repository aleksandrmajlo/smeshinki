<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeSend;
use App\Models\Welcome;
use App\Models\Word;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    public function addWelcome(Request $request)
    {
        $welcome_text = $request->welcome;
        $title = $request->title;
        $type = $request->type;

        $welcome = new Welcome();
        $welcome->type=$type;
//        if(Auth::user()){
        $welcome->user_id = Auth::user()->id;
//        }else{
//            $welcome->name=$request->name;
//            $welcome->email=$request->email;
//        }
        if ($request->has('holiday_id')) {
            $welcome->holiday_id = $request->holiday_id;
        }
        $welcome->title = $title;
        $welcome->welcome = $welcome_text;
        if ($request->photo) {
            $file = $request->file('photo');
            $welcome->photo = self::upload($file);
        }
        $welcome->save();
        // отправка почты
//        if ($welcome->user) {
        $user = $welcome->user->name . ' ' . $welcome->user->email;
//        } else {
//            $user = $welcome->name . ' ' . $welcome->email;
//        }
        $link = env('APP_URL') . '/admin/welcomes/' . $welcome->id . '/edit';
        try {
            \Mail::to(env('MAIL_TO_ADMIN'))->send(new WelcomeSend($user, $link));
            \Mail::to('alex.stepanov100@gmail.com')->send(new WelcomeSend($user, $link));
        } catch (Exception $e) {
        }
        return response()->json(['suc' => 1]);
    }

    public static function upload($file)
    {
        $fileName = "welcome_" . time() . '.' . $file->getClientOriginalExtension();
        $data = getimagesize($file);
        $destinationPath = public_path('/images/uploads');
        $file->move($destinationPath, $fileName);
        $fileBase = 'images/uploads/' . $fileName;
        return $fileBase;
    }

}
