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
                'name' => 'New message to support',
            ], [
                'name' => 'New review',
            ], [
                'name' => 'Subscription renewal failed'
            ], [
                'name' => 'Top up your balance (7 days)'
            ], [
                'name' => 'Top up your balance (3 days)'
            ], [
                'name' => 'Top up your balance (1 day)'
            ], [
                'name' => 'Moderation failed'
            ], [
                'name' => 'Moderation completed'
            ], [
                'name' => 'Similar questions'
            ], [
                'name' => 'New forum answer'
            ], [
                'name' => 'New forum comment'
            ]
        ]);
    }
}
