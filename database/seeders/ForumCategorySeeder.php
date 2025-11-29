<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('forum_categories')->insert([
            ['name' => 'News'],
            ['name' => 'Cryptocurrency'],
            ['name' => 'ASIC miners and video cards'],
            ['name' => 'Mining'],
            ['name' => 'Technologies'],
            ['name' => 'Trading'],
            ['name' => 'Legal issues'],
            ['name' => 'Technical solutions'],
            ['name' => 'Alternative earnings'],
        ]);
    }
}
