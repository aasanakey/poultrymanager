<?php

use Illuminate\Database\Seeder;

class FarmAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\FarmAdmin::create([
            "farm_id" => App\Farm::first()->id,
            "full_name" => "The Manager",
            'email' => "testaccount@mail.com",
            "contact" => "233 246 815 376",
            "role" => "SUPER_ADMIN",
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

    }
}