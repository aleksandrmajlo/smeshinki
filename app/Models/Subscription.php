<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'email_verified_at',
        'remember_token',
        'updated_at',
        'user_id'
    ];
}
