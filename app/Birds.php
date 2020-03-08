<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Birds extends Model
{
    protected $fillable = ["batch_id","farm_id","pen_id","bird_category","number","species","type","unit_price"];
}
