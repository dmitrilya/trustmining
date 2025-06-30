<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AsicBrandSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('asic_brands')->insert([
            ["name" => "Aisen"],
            ["name" => "Auradine"],
            ["name" => "BW"],
            ["name" => "Baikal"],
            ["name" => "Bitaxe"],
            ["name" => "Bitdeer"],
            ["name" => "Bitfily"],
            ["name" => "Bitfury"],
            ["name" => "Bitmain"],
            ["name" => "Bolon Miner"],
            ["name" => "Bombax Miner"],
            ["name" => "Braiins"],
            ["name" => "Canaan"],
            ["name" => "Dayun"],
            ["name" => "Digital Shovel"],
            ["name" => "DragonBall Miner"],
            ["name" => "Ebang"],
            ["name" => "ElphaPex"],
            ["name" => "FFMiner"],
            ["name" => "Fluminer"],
            ["name" => "ForestMiner"],
            ["name" => "FusionSilicon"],
            ["name" => "GMO miner"],
            ["name" => "Goldshell"],
            ["name" => "Halong Mining"],
            ["name" => "Heatbit"],
            ["name" => "Holic"],
            ["name" => "Hummer Miner"],
            ["name" => "IceRiver"],
            ["name" => "Innosilicon"],
            ["name" => "Jasminer"],
            ["name" => "Lucky Miner"],
            ["name" => "MicroBT"],
            ["name" => "NerdMiner"],
            ["name" => "Obelisk"],
            ["name" => "Pantech"],
            ["name" => "PinIdea"],
            ["name" => "Spondoolies"],
            ["name" => "StrongU"],
            ["name" => "Todek"],
            ["name" => "VolcMiner"],
            ["name" => "iBeLink"],
            ["name" => "iPollo"]
        ]);
    }
}
