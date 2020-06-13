<?php

use Illuminate\Database\Seeder;

class FarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Farm::create([
            "farm_name" => "Test Farm",
            "farm_email" => "testfarm@gmail.com",
            "farm_contact" => "5 Ayeduase Street, Kumasi",
            "farm_location" => "233 245 959 458",
            "farm_manager" => "The Farm Manager",
            "is_setup" => true,
        ]);
    }
}