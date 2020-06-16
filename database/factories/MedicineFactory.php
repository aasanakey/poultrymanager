<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Medicine;
use Faker\Generator as Faker;

$factory->define(Medicine::class, function (Faker $faker) {
    $farm_id = $faker->randomElement(\App\Farm::pluck('id')->toArray());
    return [
        "farm_id" => $farm_id,
        "name" => $faker->name,
        "price" => $faker->randomFloat(2, 30, 1000),
        "quantity" => $faker->numberBetween($min = 1, $max = 50),
        "date" => new \DateTime(),
        "supplier" => $faker->company,
        "description" =>  $faker->sentence($nbWords = 6, $variableNbWords = true),
        "animal" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});