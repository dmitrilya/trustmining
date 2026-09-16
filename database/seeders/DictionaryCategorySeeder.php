<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DictionaryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('dictionary_categories')->insert([
            ['name' => 'mining'],
            ['name' => 'mining-equipment'],
            ['name' => 'equipment-specifications'],
            ['name' => 'mining-pools'],
            ['name' => 'cooling'],
            ['name' => 'mining-infrastructure'],
            ['name' => 'mining-economics'],
            ['name' => 'blockchain'],
            ['name' => 'cryptocurrency'],
            ['name' => 'crypto-trading'],
            ['name' => 'crypto-exchanges'],
            ['name' => 'crypto-wallets'],
            ['name' => 'deFi'],
            ['name' => 'staking'],
            ['name' => 'security'],
        ]);
    }
}
