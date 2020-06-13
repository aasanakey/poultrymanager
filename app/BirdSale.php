<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirdSale extends Model
{
    protected $fillable = ["farm_id", "bird_batch_id", "weight", "price", "date", "bird_category", "number"];
    /**
     * Get the farm that owns the birdsale.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
    /**
     * Get the bird that owns the sale.
     */
    public function birds()
    {
        return $this->belongsTo('App\Birds', 'bird_batch_id', 'batch_id');
    }
}