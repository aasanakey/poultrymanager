<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        "farm_id",
        "equipment",
        "date_acquired",
        "status",
        "description",
        "supplier",
        "price",
        "type",
        "farm_category",
    ];

    /**
     * Get the farm that owns the equipment.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}