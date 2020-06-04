<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    protected $fillable = ["farm_id", "name", "price", "quantity", "date", "supplier", "description", "animal"];
}