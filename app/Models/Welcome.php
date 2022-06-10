<?php

namespace App\Models;

use App\Models\Calendar;
use App\Models\Post;
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

    public static function boot()
    {

        parent::boot();

        static::updated(function ($item) {
            // если не привязан пост значит публикация
            // и статус опубликовать
            if (is_null($item->post_id) && $item->status) {

                $post = new Post;
                $post->title = $item->title;
                $post->meta_title = $item->title;
                $post->meta_description = $item->title;
                $post->text = $item->welcome;
                $post->photo = $item->photo;
                $post->holiday_id = $item->holiday_id;
                $post->save();

                \DB::table('welcomes')
                    ->where('id', $item->id)
                    ->update(['post_id' => $post->id]);
            } else {
                // тут тупо обновить !!!!!
                if ($item->status) {
                    // обновить опубликовать
                    $post = Post::find($item->post_id);
                    $post->status = 1;
                    $post->save();
                } elseif ($item->post_id && !$item->status) {
                    // обновить не публиковать
                    $post = Post::find($item->post_id);
                    $post->status = 0;
                    $post->save();
                }
            }
        });
    }
}
