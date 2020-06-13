<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\EggProduction;
use Faker\Generator as Faker;

$factory->define(EggProduction::class, function (Faker $faker) {
    $bird = $faker->randomElement(\App\Birds::all()->toArray());
    return [
        "layer_batch_id" => $bird['batch_id'],
        "farm_id" => $bird['farm_id'],
        "pen_id" => $bird['pen_id'],
        "quantity" => $faker->numberBetween($min = 0, $max = 100),
        "date_collected" => new \DateTime(),
        "bad_eggs" => $faker->numberBetween($min = 0, $max = 5),
        "bird_category" => $bird['bird_category'],
    ];
});