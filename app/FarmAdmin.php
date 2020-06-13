<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class FarmAdmin extends Authenticatable implements MustVerifyEmail
{

    use Notifiable;
    //
    protected $fillable = [
        "farm_id",
        "full_name",
        "email",
        "contact",
        "role",
        "password",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'farm_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Check if model has a given role
     * @var string
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role == $role;
    }

    /**
     * Get the farm that owns the admin.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}