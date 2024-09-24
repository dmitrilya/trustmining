<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('tariffs')->insert([
            [
                'name' => 'Resale',
                'description' => 'For small points of sale',
                'max_ads' => 15,
                'max_offices' => 2,
                'max_contacts' => 1,
                'can_have_hosting' => 1,
                'max_description' => 500,
                'can_create_guide' => 0,
                'priority_moderation' => 0,
                'price' => 20000,
            ],
            [
                'name' => 'Company',
                'description' => 'For companies',
                'max_ads' => 60,
                'max_offices' => 5,
                'max_contacts' => 3,
                'can_have_hosting' => 1,
                'max_description' => 1500,
                'can_create_guide' => 1,
                'priority_moderation' => 1,
                'price' => 50000,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For market leaders',
                'max_ads' => 150,
                'max_offices' => 7,
                'max_contacts' => 5,
                'can_have_hosting' => 1,
                'max_description' => 1500,
                'can_create_guide' => 1,
                'priority_moderation' => 1,
                'price' => 0,
            ],
        ]);
    }
}
