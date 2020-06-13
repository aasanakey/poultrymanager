<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MeatSale extends Model
{
    public $fillable = ["farm_id", "date", "quantity", "price", "type", "part"];
   
    /**
     * Get the farm that owns the meat sale.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}