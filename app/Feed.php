<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    //
    protected $fillable = ["farm_id","name","price","quantity","description","supplier","date"];
}
