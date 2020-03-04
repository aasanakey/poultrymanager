<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class FarmAdmin extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;
    //
    protected $fillable = [
        "farm_id" ,
        "full_name" ,
        "email",
        "contact",
        "role" ,
        "password"
    ];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','farm_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
