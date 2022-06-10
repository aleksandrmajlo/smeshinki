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

    public function holiday()
    {
        return $this->belongsTo(Holiday::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getCalendarUrlAttribute($value)
    {
        return '/calendar/' . $this->calendar->slug;
    }

    public function setMetaTitleAttribute($value)
    {
        $meta_title = $value;
        if (empty($meta_title)) {
            $meta_title = $this->title;
        }
        $this->attributes['meta_title'] = $meta_title;
    }

    public function setMetaDescriptionAttribute($value)
    {
        $meta_description = $value;
        if (empty($meta_description)) {
            $meta_description = $this->title;
        }
        $this->attributes['meta_description'] = $meta_description;
    }
}
