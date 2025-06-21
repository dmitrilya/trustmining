<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('algorithms')->insert([
            [
                'id' => 1,
                'name' => 'SHA-256',
                'measurement' => 'TH',
            ], [
                'id' => 3,
                'name' => 'Scrypt',
                'measurement' => 'MH',
            ], [
                'id' => 4,
                'name' => 'Ethash',
                'measurement' => 'MH',
            ], [
                'id' => 5,
                'name' => 'Equihash',
                'measurement' => 'KSol',
            ], [
                'id' => 6,
                'name' => 'Ethash-ETHW',
                'measurement' => 'MH',
            ], [
                'id' => 7,
                'name' => 'KawPow',
                'measurement' => 'MH',
            ], [
                'id' => 8,
                'name' => 'X11',
                'measurement' => 'GH',
            ], [
                'id' => 9,
                'name' => 'SHA256-BCH',
                'measurement' => 'TH',
            ], [
                'id' => 10,
                'name' => 'Eaglesong',
                'measurement' => 'TH',
            ], [
                'id' => 11,
                'name' => 'Octopus',
                'measurement' => 'MH',
            ], [
                'id' => 12,
                'name' => 'KHeavyHash',
                'measurement' => 'TH',
            ],
        ]);
    }
}
