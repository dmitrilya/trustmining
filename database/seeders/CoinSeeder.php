<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coins')->insert([
            [
                'id' => 1,
                'name' => 'BTC',
                'algorithm_id' => 1
            ], [
                'id' => 2,
                'name' => 'LTC',
                'algorithm_id' => 3
            ], [
                'id' => 3,
                'name' => 'ETC',
                'algorithm_id' => 4
            ], [
                'id' => 4,
                'name' => 'ZEC',
                'algorithm_id' => 5
            ], [
                'id' => 5,
                'name' => 'ETHW',
                'algorithm_id' => 6
            ], [
                'id' => 6,
                'name' => 'RVN',
                'algorithm_id' => 7
            ], [
                'id' => 7,
                'name' => 'DASH',
                'algorithm_id' => 8
            ], [
                'id' => 8,
                'name' => 'BCH',
                'algorithm_id' => 9
            ], [
                'id' => 9,
                'name' => 'CKB',
                'algorithm_id' => 10
            ], [
                'id' => 10,
                'name' => 'DOGE',
                'algorithm_id' => 3
            ], [
                'id' => 11,
                'name' => 'CFX',
                'algorithm_id' => 11
            ], [
                'id' => 12,
                'name' => 'KAS',
                'algorithm_id' => 12
            ], [
                'id' => 13,
                'name' => 'USDT',
                'algorithm_id' => null
            ], [
                'id' => 21,
                'name' => 'BEL',
                'algorithm_id' => 3
            ], [
                'id' => 22,
                'name' => 'FB',
                'algorithm_id' => 1
            ], [
                'id' => 23,
                'name' => 'LKY',
                'algorithm_id' => 3
            ], [
                'id' => 24,
                'name' => 'PEP',
                'algorithm_id' => 3
            ], [
                'id' => 25,
                'name' => 'JKC',
                'algorithm_id' => 3
            ],
        ]);
    }
}
