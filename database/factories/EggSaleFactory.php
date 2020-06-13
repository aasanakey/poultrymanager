<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EggSale;
use Faker\Generator as Faker;

$factory->define(EggSale::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());

    return [
        "farm_id" => $farm['id'],
        "weight_per_dozen" =>$faker->randomFloat(2, 8, 15),
        "price_per_dozen" => $faker->randomFloat(2, 30, 1000),
        "quantity" => $faker->randomFloat(2, 10, 50),
        "date" => new \DateTime(),
        "egg_type" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});