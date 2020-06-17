<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            // FarmSeeder::class,
            // FarmAdminSeeder::class,
            PenHouseSeeder::class,
            BirdsSeeder::class,
            BirdMortalitySeeder::class,
            BirdSaleSeeder::class,
            EggProductionSeeder::class,
            EggSaleSeeder::class,
            EmployeeSeeder::class,
            EquipmentSeeder::class,
            FeedSeeder::class,
            FeedingSeeder::class,
            MeatSaleSeeder::class,
            MedicineSeeder::class,
            VaccineSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}