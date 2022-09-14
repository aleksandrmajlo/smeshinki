<?php

namespace App\Models;

use App\Models\Anecdote;
use App\Models\Calendar;
use App\Models\Post;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Welcome extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }

    public function getTitleTypeAttribute($value)
    {
        switch ($this->type) {
            case 'posts' :
                return "Привітання";
                break;

            case 'anecdotes' :
                return "Анекдот";
                break;
            case 'words' :
                return "Світлина";
                break;
        }
        return '';

    }

    public static function boot()
    {

        parent::boot();

        static::updated(function ($item) {
                /*

                $post_id = null;
                switch ($item->type) {
                    case 'posts' :

                        $post = new Post;
                        $post->title = $item->title;
                        $post->meta_title = $item->title;
                        $post->meta_description = $item->title;
                        $post->text = $item->welcome;
                        $post->photo = $item->photo;
                        $post->holiday_id = $item->holiday_id;
                        $post->save();
                        $post_id = $post->id;
                        break;

                    case 'anecdotes' :

                        $anecdote = new Anecdote;
                        $anecdote->title = $item->title;
                        $anecdote->description = $item->welcome;
                        $anecdote->meta_title = $item->title;
                        $anecdote->meta_description = $item->title;
                        $anecdote->save();
                        $post_id = $anecdote->id;
                        break;

                    case 'words' :

                        $word = new Word;
                        $word->title = $item->title;
                        $word->photo = $item->photo;
                        $word->meta_title = $item->title;
                        $word->meta_description = $item->title;
                        $word->save();
                        $post_id = $word->id;

                        break;
                }
                \DB::table('welcomes')
                    ->where('id', $item->id)
                    ->update([
                        'post_id' => $post_id,
                        'status' =>1
                    ]);

              */

        });
    }
}
