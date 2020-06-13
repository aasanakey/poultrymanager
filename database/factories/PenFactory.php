<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PenHouse;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(PenHouse::class, function (Faker $faker) {
    $farm = \App\Farm::first();
    $bird = $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']);
    return [
        "pen_id" => generate_pen_id($bird),
        "farm_id" => $farm->id,
        "location" => $faker->address(),
        "size" => $faker->randomFloat(2, 150, 1000),
        "capacity" => $faker->numberBetween($min = 30, $max = 10000),
        "bird_type" => $bird,
    ];
});