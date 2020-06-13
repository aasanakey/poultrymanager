<?php

use Illuminate\Database\Seeder;

class BirdMortalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BirdMortality::class, 25)->create();

    }
}