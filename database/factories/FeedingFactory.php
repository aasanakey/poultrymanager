<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feeding;
use Faker\Generator as Faker;

$factory->define(Feeding::class, function (Faker $faker) {
    $pen_id = $faker->randomElement(\App\PenHouse::pluck('pen_id')->toArray());
    $feed = $faker->randomElement(\App\Feed::all()->toArray());
    return [
        "farm_id" => $feed['farm_id'],
        "pen_id" => $pen_id,
        "date" => new \DateTime(),
        "feed_id" => $feed['id'],
        "feed_quantity" => $faker->randomFloat(2, 5, 50),
        "water_quantity" => $faker->randomFloat(2, 5, 20),
    ];
});