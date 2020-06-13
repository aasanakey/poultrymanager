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
            "farm_id" => 1,
            "full_name" => "The Manager",
            'email' => "testaccount@mail.com",
            "contact" => "233 246 815 376",
            "role" => "SUPER_ADMIN",
            'password' => "$2y$10$Z49BHKi4.u0f2zr5VjipXexUXuNMQM.Ku0AvBb4V7Sw...",
        ]);

    }
}