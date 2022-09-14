<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'facebook_id',
        'instagram_id',
        'telegram_id',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin(){
        return $this->role == 'admin';
    }
    public function isUser(){
        return $this->role == 'user';
    }

    public function welcomes()
    {
        return $this->hasMany(Welcome::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function($model) {
            Subscription::create([
                'email' => $model->email,
                'email_verified_at' => Carbon::now(),
                'updated_at' => null,
                'user_id'=>$model->id
            ]);
        });
    }

}
