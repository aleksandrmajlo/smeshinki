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
                'source' => 'date'
            ]
        ];
    }

    // public function limitposts()
    // {
    // return $this->hasMany(Post::class)
    // ->active()
    // ->orderBy('id', 'desc')->limit(3);
    // }

    // public function posts()
    // {
    // return $this->hasMany(Post::class)->orderBy('id', 'desc');
    // }
    // праздники
    public function holidays()
    {
        return $this->belongsToMany(Holiday::class);
    }

    public function typecalendar()
    {
        return $this->belongsTo(Typecalendar::class);
    }

    public function welcome()
    {
        return $this->hasOne(Welcome::class);
    }

    public function getUrlAttribute($value)
    {
        return env('APP_URL') . '/calendar/' . $this->slug;
    }

    public function getDateWriteAttribute($value)
    {
        $ar_uk = [
            '1' => 'cіченя',
            '2' => 'лютого',
            '3' => 'березня',
            '4' => 'квітеня',
            '5' => 'травня',
            '6' => 'червня',
            '7' => 'липня',
            '8' => 'серпня',
            '9' => 'вересня',
            '10' => 'жовтня',
            '11' => 'листопада',
            '12' => 'грудня',
        ];
        $date = new Carbon($this->date);
        $day = $date->day;
        if ($day < 10) {
            $day = '0' . $day;
        }
        $month = $date->month;
        $year = $date->year;
        return $day . ' ' . $ar_uk[$month] . ' ' . $year;
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $this->date;
    }

    public function setMetaTitleAttribute($value)
    {
        $meta_title = $value;
        if (empty($meta_title)) {
            $meta_title = $this->date;
        }
        $this->attributes['meta_title'] = $meta_title;
    }

    public function setMetaDescriptionAttribute($value)
    {
        $meta_description = $value;
        if (empty($meta_description)) {
            $meta_description = $this->date;
        }
        $this->attributes['meta_description'] = $meta_description;
    }
}
