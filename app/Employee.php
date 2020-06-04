<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    // to prevent the id from being truncating doing fetch operations
    public $incrementing = false;
    protected $fillable = ["id", "farm_id", "full_name", "dob", "email", "contact", "hire_date", "jd", "photo", "farm_category"];
}
