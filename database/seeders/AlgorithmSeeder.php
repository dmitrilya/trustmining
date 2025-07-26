<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AlgorithmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('algorithms')->insert([
            ["name" => "SHA-256", "measurement" => "Th"],
            ["name" => "Scrypt", "measurement" => "Mh"],
            ["name" => "RandomX", "measurement" => "kh"],
            ["name" => "ETCHash", "measurement" => "Mh"],
            ["name" => "KHeavyHash", "measurement" => "Th"],
            ["name" => "Equihash", "measurement" => "kh"],
            ["name" => "Cuckatoo31", "measurement" => "h"],
            ["name" => "Octopus", "measurement" => "Mh"],
            ["name" => "X11", "measurement" => "Gh"],
            ["name" => "KawPow", "measurement" => "Mh"],
            ["name" => "Blake (2b-Sia)", "measurement" => "Gh"],
            ["name" => "Eaglesong", "measurement" => "Th"],
            ["name" => "Qubit", "measurement" => "Gh"],
            ["name" => "Blake (2s-Kadena)", "measurement" => "Gh"],
            ["name" => "zkSNARK", "measurement" => "Mh"],
            ["name" => "Blake3", "measurement" => "Gh"],
            ["name" => "Groestl", "measurement" => "Gh"],
            ["name" => "Lyra2REv2", "measurement" => "Gh"],
            ["name" => "NexaPow", "measurement" => "Mh"],
            ["name" => "Handshake", "measurement" => "Gh"],
            ["name" => "CryptoNight", "measurement" => "kh"],
            ["name" => "Cuckatoo32", "measurement" => "h"],
            ["name" => "Blake (14r)", "measurement" => "Th"],
            ["name" => "SHA512256d", "measurement" => "Gh"],
            ["name" => "Lbry", "measurement" => "Gh"],
            ["name" => "CryptoNight-LiteV1", "measurement" => "kh"],
            ["name" => "Autolykos2", "measurement" => "Mh"],
            ["name" => "Nist5", "measurement" => "Th"],
            ["name" => "Tensority", "measurement" => "kh"],
            ["name" => "Cryptonight-V7", "measurement" => "Th"],
            ["name" => "GhostRider", "measurement" => "Th"],
            ["name" => "CryptoNightR", "measurement" => "kh"],
            ["name" => "Myr-Groestl", "measurement" => "Mh"],
            ["name" => "RandomHash2", "measurement" => "h"],
            ["name" => "ProgPow", "measurement" => "Mh"],
            ["name" => "Blake (2b)", "measurement" => "Gh"],
            ["name" => "X11Gost", "measurement" => "Gh"],
            ["name" => "X13", "measurement" => "Mh"],
            ["name" => "Ethash", "measurement" => "Mh"],
        ]);
    }
}
