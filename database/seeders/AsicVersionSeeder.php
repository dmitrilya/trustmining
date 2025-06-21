<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AsicVersionSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asic_versions')->insert([
            [
                'asic_model_id' => 1,
                'hashrate' => '115',
                'efficiency' => '15',
            ], [
                'asic_model_id' => 1,
                'hashrate' => '120',
                'efficiency' => '15',
            ], [
                'asic_model_id' => 2,
                'hashrate' => '190',
                'efficiency' => '12',
            ], [
                'asic_model_id' => 3,
                'hashrate' => '104',
                'efficiency' => '20',
            ], [
                'asic_model_id' => 3,
                'hashrate' => '108',
                'efficiency' => '20',
            ], [
                'asic_model_id' => 3,
                'hashrate' => '110',
                'efficiency' => '20',
            ], [
                'asic_model_id' => 4,
                'hashrate' => '120',
                'efficiency' => '18',
            ], [
                'asic_model_id' => 4,
                'hashrate' => '122',
                'efficiency' => '18',
            ]
        ]);
    }
}
