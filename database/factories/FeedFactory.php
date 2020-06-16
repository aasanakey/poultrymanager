<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feed;
use Faker\Generator as Faker;

$factory->define(Feed::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());
    return [
        "farm_id" => $farm['id'],
        "name" => $faker->randomElement(["Wheat", "Corn", "Sorghum", "Barley", "Rye", "Oats", "Triticale", "Soya beans"]),
        "price" => $faker->randomFloat(2, 30, 1000),
        "quantity" => $faker->randomFloat(2, 10, 100),
        "description" =>  $faker->sentence($nbWords = 6, $variableNbWords = true),
        "supplier" => $faker->company(),
        "feed_type" => $faker->randomElement(['chicken', 'guinea_fowl', 'turkey']),
        "date" => new \DateTime(),
    ];
});