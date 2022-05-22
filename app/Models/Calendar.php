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
        $ar_uk=[
          '1'=>'cіченя',
          '2'=>'лютого',
          '3'=>'березня',
          '4'=>'квітеня',
          '5'=>'травня',
          '6'=>'червня',
          '7'=>'липня',
          '8'=>'серпня',
          '9'=>'вересня',
          '10'=>'жовтня',
          '11'=>'листопада',
          '12'=>'грудня',
        ];
        $date=new Carbon($this->date);
        $day=$date->day;
        if($day<10){
            $day='0'.$day;
        }
        $month=$date->month;
        $year=$date->year;
        return $day.' '.$ar_uk[$month].' '.$year;
    }


}
