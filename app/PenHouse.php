<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenHouse extends Model
{
    // protected $primaryKey = 'pen_id'; //['pen_id', 'farm_id']
    protected $fillable = ["pen_id", "farm_id", "location", "size", "capacity", "bird_type"];
    /**
     * Get the comments for the blog post.
     */
    public function birds()
    {
        return $this->hasMany('App\Birds', 'pen_id', 'pen_id');
    }

    /**
     * Get the farm that owns the pen.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}