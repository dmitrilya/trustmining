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
                'settings' => ["c" => ["d", "c"]]
            ],
            [
                'name' => 'Price drop',
                'settings' => []
            ],
            [
                'name' => 'Price increase',
                'settings' => []
            ],
            [
                'name' => 'New message from support',
                'settings' => []
            ],
            [
                'name' => 'New message to support',
                'settings' => []
            ],
            [
                'name' => 'New message',
                'settings' => ["f" => ["f", "a"]]
            ],
            [
                'name' => 'New review',
                'settings' => ["c" => ["n", "a"]]
            ],
            [
                'name' => 'Review edited',
                'settings' => ["c" => ["n", "a"]]
            ],
            [
                'name' => 'Subscription renewal failed',
                'settings' => []
            ],
            [
                'name' => 'Top up your balance (7 days)',
                'settings' => []
            ],
            [
                'name' => 'Top up your balance (3 days)',
                'settings' => []
            ],
            [
                'name' => 'Top up your balance (1 day)',
                'settings' => []
            ],
            [
                'name' => 'Moderation failed',
                'settings' => []
            ],
            [
                'name' => 'Moderation completed',
                'settings' => []
            ],
            [
                'name' => 'New moderation',
                'settings' => []
            ],
            [
                'name' => 'Similar questions',
                'settings' => []
            ],
            [
                'name' => 'New forum answer',
                'settings' => []
            ],
            [
                'name' => 'New forum comment',
                'settings' => []
            ],
            [
                'name' => 'Difficulty changing',
                'settings' => ["f" => ["12h", "d", "3d", "c"]]
            ],
            [
                'name' => 'New publication',
                'settings' => []
            ],
        ]);
    }
}
