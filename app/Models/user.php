<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class user extends Authenticatable
{
    use HasFactory,HasApiTokens,Notifiable;
    
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'mobile',
        'password',
        'otp',
    ];


    protected $hidden = [
        'password',
        'otp',
        //'remember_token',
    ];



    protected $attributes = [
        'otp' =>'0',
    ];
}
