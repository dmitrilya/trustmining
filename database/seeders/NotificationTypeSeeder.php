<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('notification_types')->insert([
            [
                'name' => 'Price change',
            ], [
                'name' => 'Price drop',
            ], [
                'name' => 'Price increase',
            ], [
                'name' => 'New message from support',
            ], [
                'name' => 'New review',
            ], [
                'name' => 'Subscription renewal failed'
            ], [
                'name' => 'Top up your balance'
            ], [
                'name' => 'Moderation failed'
            ], [
                'name' => 'Moderation completed'
            ]
        ]);
    }
}
