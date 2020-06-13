<?php

use Illuminate\Database\Seeder;

class EggProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EggProduction::class, 50)->create();

    }
}
