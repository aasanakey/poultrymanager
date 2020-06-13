<?php

use Illuminate\Database\Seeder;

class EggSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\EggSale::class, 50)->create();

    }
}
