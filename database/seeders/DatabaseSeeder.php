<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        $this->call([
            RoleSeeder::class,
            TariffSeeder::class,
            AdCategorySeeder::class,

            AlgorithmSeeder::class,
            CoinSeeder::class,
            AsicBrandSeeder::class,
            AsicModelSeeder::class,
            AsicVersionSeeder::class,

            ModerationStatusSeeder::class,
            ContactTypeSeeder::class,
            NotificationTypeSeeder::class
        ]);
    }
}
