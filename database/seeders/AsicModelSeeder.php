<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use DB;

class AsicModelSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('asic_models')->insert([
            [
                'asic_brand_id' => 1,
                'name' => 'Antminer S19k Pro',
                'description' => 'kekekekekekk kekekekkeke kekekekekek',
                'width' => '15',
                'length' => '35',
                'height' => '20',
                'weight' => '12',
                'images' => '[]'
            ], [
                'asic_brand_id' => 1,
                'name' => 'Antminer T21',
                'description' => 'kekekekekekk kekekekkeke kekekekekek',
                'width' => '15',
                'length' => '35',
                'height' => '20',
                'weight' => '12',
                'images' => '[]'
            ], [
                'asic_brand_id' => 2,
                'name' => 'Whatsminer M30S++',
                'description' => 'kekekekekekk kekekekkeke kekekekekek',
                'width' => '15',
                'length' => '35',
                'height' => '20',
                'weight' => '12',
                'images' => '[]'
            ], [
                'asic_brand_id' => 2,
                'name' => 'Whatsminer M50',
                'description' => 'kekekekekekk kekekekkeke kekekekekek',
                'width' => '15',
                'length' => '35',
                'height' => '20',
                'weight' => '12',
                'images' => '[]'
            ]
        ]);
    }
}
