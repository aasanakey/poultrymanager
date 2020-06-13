<?php

use Illuminate\Database\Seeder;

class BirdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Birds::class, 50)->create();

    }
}
