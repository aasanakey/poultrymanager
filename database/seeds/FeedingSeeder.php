<?php

use Illuminate\Database\Seeder;

class FeedingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Feeding::class, 50)->create();
    }
}
