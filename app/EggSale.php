<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EggSale extends Model
{
    protected $fillable = ["farm_id","weight_per_dozen","price_per_dozen","quantity","date","egg_type"];
}
