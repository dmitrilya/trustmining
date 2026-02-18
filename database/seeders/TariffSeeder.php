<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('tariffs')->insert([
            [
                'name' => 'Resale',
                'description' => 'For small points of sale',
                'max_ads' => 20,
                'max_offices' => 1,
                'can_have_hosting' => 0,
                'can_have_phone' => 0,
                'can_site_link' => 0,
                'max_description' => 500,
                'can_create_insight' => 0,
                'priority_moderation' => 0,
                'price' => 600,
            ],
            [
                'name' => 'Company',
                'description' => 'For medium-sized companies',
                'max_ads' => 60,
                'max_offices' => 3,
                'can_have_hosting' => 1,
                'can_have_phone' => 1,
                'can_site_link' => 0,
                'max_description' => 1500,
                'can_create_insight' => 1,
                'priority_moderation' => 1,
                'price' => 1500,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For market leaders',
                'max_ads' => 150,
                'max_offices' => 7,
                'can_have_hosting' => 1,
                'can_have_phone' => 1,
                'can_site_link' => 1,
                'max_description' => 1500,
                'can_create_insight' => 1,
                'priority_moderation' => 1,
                'price' => 2300,
            ],
            [
                'name' => 'Subscription',
                'description' => 'For profitable purchases',
                'max_ads' => 2,
                'max_offices' => 1,
                'can_have_hosting' => 0,
                'can_have_phone' => 0,
                'can_site_link' => 0,
                'max_description' => 0,
                'can_create_insight' => 0,
                'priority_moderation' => 0,
                'price' => 15,
            ],
        ]);
    }
}
