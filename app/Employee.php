<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ["id", "farm_id", "full_name", "dob", "email", "contact", "hire_date", "jd", "photo", "farm_category"];
}
