<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    protected $fillable = ["farm_id", "pen_id", "date", "feed_id", "feed_quantity", "water_quantity"];

    /**
     * Get the farm that owns the feeding.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }

    /**
     * Get the pen that owns the feeding.
     */
    public function pen()
    {
        return $this->belongsTo('App\PenHouse', 'pen_id', 'pen_id');
    }
}