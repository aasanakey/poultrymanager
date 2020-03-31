<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirdSale extends Model
{
    protected $fillable = ["farm_id", "bird_batch_id", "weight", "price", "date","bird_category","number"];
}