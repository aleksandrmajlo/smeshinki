<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{

    // получаем картинки
    // прочее на  главной
    public function index(Request $request)
    {
        $limit = config('app.limit');

        $type=$request->type;

        $firstId=$request->firstId;
        $firstIdCol=true;// первое ид вообще

        $lastId=$request->lastId;
        $lastIdCol=true;// последнее ид вообще

        $words_all=Word::orderBy('created_at', 'desc')->active()->get();
        $count=$words_all->count();// количество записей

        $firstIdCol_=$words_all->first();
        $firstIdCol=$firstIdCol_->id;

        $lastIdCol_=$words_all->last();
        $lastIdCol=$lastIdCol_->id;

        $words=false;
        if(is_null($firstId)&&is_null($lastId)){

            $words=$words_all->take($limit);

            $firstIdEl=$words->first();
            $firstId=$firstIdEl->id;

            $lastIdEl=$words->last();
            $lastId=$lastIdEl->id;

        }elseif($type=='down'){
            // берем следующую запись
            // вниз по списку id уменьшается
            $next = Word::orderBy('created_at', 'desc')->active()->where('id', '<', $lastId)->first();
            $words=Word::orderBy('created_at', 'desc')->active()->where('id', '<', $firstId)->where('id', '>=', $next->id)->get();
            $firstIdEl=$words->first();
            $firstId=$firstIdEl->id;
            $lastId=$next->id;
        }elseif ($type=='top'){
           //берем ид по возостанию
            // исключая самое первое ид
            $previous_id = Word::orderBy('created_at', 'desc')->active()->where('id', '>', $firstId)->min('id');
            $words=Word::orderBy('created_at', 'desc')->active()->where('id', '<=', $previous_id)->where('id', '>', $lastId)->get();
            $firstId=$previous_id;
            $lastIdEl=$words->last();
            $lastId=$lastIdEl->id;
        }elseif($type=='ten'){
            // показать еще 10
            $count_th = Word::orderBy('created_at', 'desc')->active()->where('id', '<=', $firstId)->where('id', '>=', $lastId)->count();
            $words=Word::orderBy('created_at', 'desc')->active()->where('id', '<=', $firstId)->take($limit+$count_th)->get();
            $lastIdEl=$words->last();
            $lastId=$lastIdEl->id;
        }

        return response()
            ->json([
                'words'=>$words,
                'firstId'=>$firstId,
                'lastId'=>$lastId,
                'firstIdCol'=>$firstIdCol,
                'lastIdCol'=>$lastIdCol,
                'count'=>$count
            ]);
    }

}
