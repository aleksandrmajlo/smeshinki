<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Anecdote extends Model
{
    use HasFactory;
    use Sluggable;
    protected $appends = ['likes'];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // кол-во лайков
    public function getLikesAttribute($value){
        $likes=\DB::table('count_likes')
            ->where('post_type','anecdote')
            ->where('post_id',$this->id)
            ->get();
        $res=[];
        foreach ($likes as $like){
            $res[$like->like.'_n']=$like->count;
        }
        return $res;
    }

}
