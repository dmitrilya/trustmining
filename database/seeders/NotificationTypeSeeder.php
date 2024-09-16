<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('notification_types')->insert([
            [
                'name' => 'Price drop',
            ], [
                'name' => 'Price increase',
            ], [
                'name' => 'Support',
            ], [
                'name' => 'Advice',
            ], [
                'name' => 'Warning',
            ], [
                'name' => 'Review',
            ]
        ]);
    }
}
