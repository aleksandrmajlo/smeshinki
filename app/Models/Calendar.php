<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Calendar extends Model
{
    use HasFactory;
    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function limitposts(){
        return $this->hasMany(Post::class)->orderBy('id','desc')->limit(3);
    }
    public function posts(){
        return $this->hasMany(Post::class)->orderBy('id','desc');
    }
    public function typecalendar()
    {
        return $this->belongsTo(Typecalendar::class);
    }

    public function getUrlAttribute($value)
    {
        return env('APP_URL').'/calendar/'.$this->slug;
    }

    public function getDateWriteAttribute($value)
    {
        $date=new Carbon($this->date);
        $date_only = $date->formatLocalized( '%d.%m.%Y');
        return $date_only;
    }
}
