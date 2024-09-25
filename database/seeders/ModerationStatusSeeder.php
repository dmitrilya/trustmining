<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class ModerationStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('moderation_statuses')->insert([
            [
                'name' => 'moderation',
            ], [
                'name' => 'accepted',
            ], [
                'name' => 'declined',
            ], [
                'name' => 'canceled',
            ]
        ]);
    }
}
