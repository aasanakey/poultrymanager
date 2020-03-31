<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeatSale extends Model
{
    public $fillable = ["farm_id", "date", "quantity", "price", "type", "part"];
}