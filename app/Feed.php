<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    //
    protected $fillable = ["farm_id", "name", "price", "quantity", "description", "supplier", "date", "feed_type"];

    /**
     * Get the farm that owns the feed.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}