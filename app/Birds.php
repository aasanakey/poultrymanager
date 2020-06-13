<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Birds extends Model
{
    // protected $primaryKey = 'batch_id';
    protected $fillable = ["batch_id", "farm_id", "pen_id", "bird_category", "number", "species", "type", "unit_price", "date"];

    /**
     * Get the pen that owns the birds.
     */
    public function pen()
    {
        return $this->belongsTo('App\PenHouse', 'pen_id', 'pen_id');
    }

    /**
     * Get the farm that owns the birds.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }

    /**
     * Get the mortality for the birds.
     */
    public function mortality()
    {
        return $this->hasMany('App\BirdMortality', 'batch_id', 'batch_id');
    }

    /**
     * Get the sale for the birds.
     */
    public function sales()
    {
        return $this->hasMany('App\BirdSale', 'bird_batch_id', 'batch_id');
    }
}