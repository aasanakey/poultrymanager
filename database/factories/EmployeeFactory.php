<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());
    $age = rand(10, 30);
    $hd = rand(2, 10);
    return [
        'employee_id' => uniqid(true) . '__' . $farm['id'],
        "farm_id" => $farm['id'],
        "full_name" => $faker->name,
        "dob" => date('Y-m-d', strtotime("-$age years")),
        "email" => $faker->unique->safeEmail,
        "hire_date" => date('Y-m-d', strtotime("-$hd years")),
        "contact" => $faker->phoneNumber,
        "photo" => null,
        "jd" => $faker->sentence($nbWords = 6, $variableNbWords = true),
        "farm_category" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});