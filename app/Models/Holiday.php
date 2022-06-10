<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Holiday extends Model
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

    public function calendars()
    {
        return $this->belongsToMany(Calendar::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
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
