<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    //
    protected $fillable = ["farm_id", "name", "price", "quantity", "date", "supplier", "description", "animal"];

    /**
     * Get the farm that owns the medicine.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}