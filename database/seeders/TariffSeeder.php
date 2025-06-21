<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class TariffSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tariffs')->insert([
            [
                'name' => 'Resale',
                'description' => 'For small points of sale',
                'max_ads' => 15,
                'max_offices' => 2,
                'max_contacts' => 1,
                'can_have_hosting' => 0,
                'can_site_link' => 0,
                'max_description' => 500,
                'can_create_guide' => 0,
                'priority_moderation' => 0,
                'price' => 600,
            ],
            [
                'name' => 'Company',
                'description' => 'For medium-sized companies',
                'max_ads' => 60,
                'max_offices' => 4,
                'max_contacts' => 2,
                'can_have_hosting' => 1,
                'can_site_link' => 0,
                'max_description' => 1500,
                'can_create_guide' => 1,
                'priority_moderation' => 1,
                'price' => 1400,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'For market leaders',
                'max_ads' => 150,
                'max_offices' => 7,
                'max_contacts' => 5,
                'can_have_hosting' => 1,
                'can_site_link' => 1,
                'max_description' => 1500,
                'can_create_guide' => 1,
                'priority_moderation' => 1,
                'price' => 2000,
            ],
            [
                'name' => 'Subscription',
                'description' => 'description',
                'max_ads' => 0,
                'max_offices' => 0,
                'max_contacts' => 0,
                'can_have_hosting' => 0,
                'can_site_link' => 0,
                'max_description' => 0,
                'can_create_guide' => 0,
                'priority_moderation' => 0,
                'price' => 500,
            ],
        ]);
    }
}
