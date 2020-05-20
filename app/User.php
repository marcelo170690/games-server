<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'id', 'photo', 'first_name', 'last_name', 'password', 'username'
    ];

    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
