<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Vaccine;
use Faker\Generator as Faker;

$factory->define(Vaccine::class, function (Faker $faker) {
    $farm_id = $faker->randomElement(\App\Farm::pluck('id')->toArray());
    $vaccine = $faker->randomElement([
        ["Mareks", "Mareks", "1 day", "Run meat"],
        ["BCRDV", "Newcastle", "7 day", "Two whit in two eyes"],
        ["Gumboro Live", "Gumboro", "14-18 day", "One whit in one eye"],
        ["Fowl Pox", "Chicken Pox", "30 day", "Under wing skin"],
        ["Salmonella Live", "Fowl Typhoid", "6 and 16 week", "Injection in meat"],
        ["RDV", "Newcastle", "60 day and 6 month", "Injection in run"],
        ["Mycoplasma", "Mycoplasmosis", "9-10 week", "Under skin of neck"],
        ["Cholera", "Poultry Cholera", "75, 90 day and 6 month", "Under skin of neck"],
        ["Gumboro Killed", "	Gumboro", "18-20 week", "Under skin of neck"],
        ["Duck Plague", "Duck Plague", "30, 45 day and 6 month", "Injection in run meat"],
    ]);

    return [
        //
        "farm_id" => $farm_id,
        "type" => $vaccine[0],
        "disease" => $vaccine[1],
        "age" => $vaccine[2],
        "mode" => $vaccine[3],
        "animal" => $faker->randomElement(['chicken', 'turkey', 'guinea_fowl']),
    ];
});
