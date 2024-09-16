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
                'name' => 'SHA-256',
                'measurement' => 'TH',
            ], [
                'name' => 'Scrypt',
                'measurement' => 'MH',
            ], [
                'name' => 'Equihash',
                'measurement' => 'KSol',
            ], [
                'name' => 'Ethash',
                'measurement' => 'MH',
            ], [
                'name' => 'X11',
                'measurement' => 'GH',
            ], [
                'name' => 'KHeavyHash',
                'measurement' => 'TH',
            ]
        ]);
    }
}
