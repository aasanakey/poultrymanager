<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    $farm = $faker->randomElement(\App\Farm::all()->toArray());

    return [
        "farm_id" => $farm['id'],
        "type" => $faker->randomElement(['income', 'expense']),
        "date" => new \DateTime(),
        "amount" => $faker->randomFloat(2, 30, 1000),
        "category" => $faker->words($nb = 3, $asText = true),
        "account" => $faker->name,
        "description" => $faker->sentence($nbWords = 6, $variableNbWords = true),
        "farm_category" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});