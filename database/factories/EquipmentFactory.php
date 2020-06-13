<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());
    return [
        "farm_id" => $farm['id'],
        "equipment" => $faker->name,
        "date_acquired" => new \DateTime(),
        "price" => $faker->randomFloat(2, 30, 1000),
        "supplier" => $faker->company,
        "type" => $faker->domainWord,
        "status" => $faker->randomElement(['Functioning', 'Maintenance', 'Non Functioning']),
        "description" => $faker->sentence($nbWords = 6, $variableNbWords = true),
        "farm_category" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});