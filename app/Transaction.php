<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "farm_id",
        "type",
        "date",
        "amount",
        "category",
        "account",
        "description",
        "farm_category",
    ];

    /**
     * Get the farm that owns the transaction.
     */
    public function farm()
    {
        return $this->belongsTo('App\Farm', 'farm_id');
    }
}