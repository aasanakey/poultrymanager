<?php

use Illuminate\Database\Seeder;

class PenHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 50)->create()->each(function ($user) {
        //     $user->posts()->save(factory(App\Post::class)->make());
        // });
        factory(App\PenHouse::class, 50)->create();

    }
}
