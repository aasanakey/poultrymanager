<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EggProduction extends Model
{
    protected $fillable = [
        "farm_id",	"pen_id","quantity","bad_eggs",	"bird_category",	"layer_batch_id",	"date_collected"
    ];
}
