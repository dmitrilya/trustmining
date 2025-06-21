<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AsicBrandSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asic_brands')->insert([
            [
                'name' => 'Bitmain',
            ], [
                'name' => 'MicroBT',
            ]
        ]);
    }
}
