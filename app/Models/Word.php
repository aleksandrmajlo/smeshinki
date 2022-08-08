<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Cviebrock\EloquentSluggable\Sluggable;

class Word extends Model
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

    public function setTitleAttribute($v)
    {
        if (is_null($v)) {
            $this->attributes['title'] = 'Не вказана';
        } else {
            $this->attributes['title'] = $v;
        }
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // кол-во лайков
    public function getLikesAttribute($value){
        $likes=\DB::table('count_likes')
            ->where('post_type','word')
            ->where('post_id',$this->id)
            ->get();
        $res=[];
        foreach ($likes as $like){
            $res[$like->like.'_n']=$like->count;
        }
        return $res;
    }
}
