<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Birds;
use Faker\Generator as Faker;

$factory->define(Birds::class, function (Faker $faker) {
    $pen = $faker->randomElement(\App\PenHouse::all()->toArray());
    $pen_id = $pen['pen_id'];
    $farm_id = $pen['farm_id'];
    $bird = $pen['bird_type'];
    $farm_name = \App\Farm::find($farm_id)->farm_name;
    $type = $bird == 'chicken' ? $faker->randomElement(['layer', 'broiler']) : null;
    $species = ($bird == 'chicken') ? $faker->randomElement([
        'Rhode Island Reds',
        'Sussex',
        'Plymouth',
        'Australorp',
        'Wyandotte',
        'Jersey Giant',
        'Leghorn',
        'Orpington',
        'Barnevelder',
        'Marans',
    ]) : $bird == 'turkey' ? $faker->randomElement([
        'White Holland',
        'Black Turkey',
        'Standard Bronze',
        'Narragansett',
        'Midget White',
        'Beltsville Small White',
        'Bourbon Reds',
        'Blue Slate',
    ]) : $faker->randomElement([
        "White-breasted",
        "Black guineafowl",
        "Helmeted guineafowl",
        "Plumed guineafowl",
        "Crested guineafowl",
        "Vulturine guineafowl",
    ]);
    return [
        "batch_id" => generate_batch_id($farm_name, $bird),
        "farm_id" => $farm_id,
        "bird_category" => $bird,
        'pen_id' => $pen_id,
        'number' => $faker->numberBetween($min = 30, $max = 10000),
        "species" => $species,
        "type" => $type,
        "unit_price" => $faker->randomFloat(2, 30, 1000),
        "date" => new \DateTime(),
    ];
});