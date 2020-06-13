<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BirdSale;
use Faker\Generator as Faker;

$factory->define(BirdSale::class, function (Faker $faker) {
    $bird = $faker->randomElement(\App\Birds::all()->toArray());
    return [
        "farm_id" => $bird['farm_id'],
        "bird_batch_id" => $bird['batch_id'],
        "weight" => $faker->randomFloat(2, 10, 50),
        "price" => $faker->randomFloat(2, 30, 1000),
        "date" => new \DateTime(),
        "bird_category" => $bird['bird_category'],
        "number" => round($bird['number'] * (10 / 100)),
    ];
});