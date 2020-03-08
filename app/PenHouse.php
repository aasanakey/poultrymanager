<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenHouse extends Model
{
    protected $fillable = ["pen_id","farm_id","location" ,"size","capacity"];
}
