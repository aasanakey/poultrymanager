<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    //
    protected $fillable = ["farm_id", "age", "disease", "mode", "type", "animal"];

    /**
     * Get the farm that owns the vaccine.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}