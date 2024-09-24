<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('roles')->insert([
            [
                'name' => 'admin',
            ],
            [
                'name' => 'user',
            ],
            [
                'name' => 'moderator',
            ],
            [
                'name' => 'support',
            ],
        ]);
    }
}
