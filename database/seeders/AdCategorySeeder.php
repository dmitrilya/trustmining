<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('ad_categories')->insert([
            [
                'name' => 'miners',
            ]
        ]);
    }
}
