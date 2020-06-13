<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\BirdMortality;
use Faker\Generator as Faker;

$factory->define(BirdMortality::class, function (Faker $faker) {
    $bird = $faker->randomElement(\App\Birds::all()->toArray());
    return [
        "batch_id" => $bird['batch_id'],
        "farm_id" => $bird['farm_id'],
        "pen_id" => $bird['pen_id'],
        "number" => round(($bird['number'] * (1 / 4))),
        "dod" => new \DateTime(),
        "unit_price" => $bird['unit_price'],
        "cause" => $faker->randomElement(['disease', 'slaughter', 'unknown']),
        "observation" => $faker->sentence($nbWords = 6, $variableNbWords = true),
    ];
});