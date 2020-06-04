<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    //
    protected $fillable = ["farm_id", "age", "disease", "mode", "type", "animal"];
}