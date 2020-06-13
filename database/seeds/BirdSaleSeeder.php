<?php

use Illuminate\Database\Seeder;

class BirdSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BirdSale::class, 50)->create();

    }
}
