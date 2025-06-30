<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModerationStatusSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('moderation_statuses')->insert([
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
