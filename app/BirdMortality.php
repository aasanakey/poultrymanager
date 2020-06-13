<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BirdMortality extends Model
{
    //
    protected $table = 'bird_mortality';
    protected $fillable = ["batch_id", "farm_id", "pen_id", "number", "cause", "observation", "unit_price", "dod"];

    /**
     * Get the bird that owns the mortality.
     */
    public function birds()
    {
        return $this->belongsTo('App\Birds', 'batch_id', 'batch_id');
    }

}