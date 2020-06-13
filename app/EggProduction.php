<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EggProduction extends Model
{
    protected $fillable = [
        "farm_id", "pen_id", "quantity", "bad_eggs", "bird_category", "layer_batch_id", "date_collected",
    ];

    /**
     * Get the farm that owns the eggs.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
    /**
     * Get the bird that owns the eggs.
     */
    public function birds()
    {
        return $this->belongsTo('App\Birds', 'layer_batch_id', 'batch_id');
    }

    /**
     *
     * Get the pen that owns the eggs.
     */
    public function pen()
    {
        return $this->belongsTo('App\PenHouse', 'pen_id');
    }
}