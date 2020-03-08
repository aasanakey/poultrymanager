<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirdMortality extends Model
{
    //
    protected $table = 'bird_mortality';
    protected $fillable = ["batch_id","farm_id","pen_id","number","cause","observation","unit_price","dod"];

}
