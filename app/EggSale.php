<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EggSale extends Model
{
    protected $fillable = ["farm_id", "weight_per_dozen", "price_per_dozen", "quantity", "date", "egg_type"];

    /**
     * Get the farm that owns the eggs.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}