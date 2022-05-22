<?php

namespace App\Http\Controllers;

use App\Models\Welcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    public function addWelcome(Request $request){
        $welcome=new Welcome();
        if(Auth::user()){
            $welcome->user_id=Auth::user()->id;
        }else{
            $welcome->name=$request->name;
            $welcome->email=$request->email;
        }
        $welcome->welcome=$request->welcome;
        if ($request->photo) {
            $file = $request->file('photo');
            $welcome->photo = self::upload($file);
        }

        $welcome->save();
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
