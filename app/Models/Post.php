<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
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

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }

    public function scopeActive($query)
    {
      return $query->where('status', 1);
    }

    public function getCalendarUrlAttribute($value)
    {
        return '/calendar/'.$this->calendar->slug;
    }
}
