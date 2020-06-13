<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MeatSale;
use Faker\Generator as Faker;

$factory->define(MeatSale::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());
    return [
        "farm_id" => $farm['id'],
        "type" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
        "part" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
        "price" => $faker->randomFloat(2, 30, 1000),
        "quantity" => $faker->randomFloat(2, 10, 100),
        "date" => new \DateTime(),
    ];
});
