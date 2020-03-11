<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    protected $fillable = ["farm_id","pen_id","date","feed_id","feed_quantity" ,"water_quantity"];
}
