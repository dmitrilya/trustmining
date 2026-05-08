<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DifficultySubscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('difficulty_subscription_types')->insert([
            ['name' => 'Every 12 hours'],
            ['name' => 'Daily'],
            ['name' => 'Every 3 days'],
            ['name' => 'On difficulty change'],
        ]);
    }
}
