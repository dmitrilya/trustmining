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
            ["name" => "RandomX", "measurement" => "Th"],
            ["name" => "EtHash", "measurement" => "Mh"],
            ["name" => "KHeavyHash", "measurement" => "Th"],
            ["name" => "Equihash", "measurement" => "kh"],
            ["name" => "Cuckatoo31", "measurement" => "Th"],
            ["name" => "Octopus", "measurement" => "Th"],
            ["name" => "X11", "measurement" => "Gh"],
            ["name" => "KawPow", "measurement" => "Th"],
            ["name" => "Blake2B-Sia", "measurement" => "Th"],
            ["name" => "Eaglesong", "measurement" => "Th"],
            ["name" => "Qubit", "measurement" => "Th"],
            ["name" => "Kadena", "measurement" => "Th"],
            ["name" => "zkSNARK", "measurement" => "Mh"],
            ["name" => "Blake3", "measurement" => "Gh"],
            ["name" => "Groestl", "measurement" => "Gh"],
            ["name" => "Lyra2REv2", "measurement" => "Gh"],
            ["name" => "NexaPow", "measurement" => "Gh"],
            ["name" => "Handshake", "measurement" => "Gh"],
            ["name" => "CryptoNight", "measurement" => "Th"],
            ["name" => "Cuckatoo32", "measurement" => "h"],
            ["name" => "Blake256R14", "measurement" => "Th"],
            ["name" => "SHA512256d", "measurement" => "Gh"],
            ["name" => "Lbry", "measurement" => "Gh"],
            ["name" => "CryptoNight-LiteV1", "measurement" => "Th"],
            ["name" => "Autolykos", "measurement" => "Th"],
            ["name" => "Nist5", "measurement" => "Th"],
            ["name" => "Tensority", "measurement" => "kh"],
            ["name" => "Cryptonight-V7", "measurement" => "Th"],
            ["name" => "GhostRider", "measurement" => "Th"],
            ["name" => "CryptoNightR", "measurement" => "kh"],
            ["name" => "Myriad-Groestl", "measurement" => "Th"],
            ["name" => "Pascal", "measurement" => "Th"],
            ["name" => "ProgPow", "measurement" => "Th"],
            ["name" => "Blake2B", "measurement" => "Gh"],
            ["name" => "X11Gost", "measurement" => "Th"],
            ["name" => "X13", "measurement" => "Th"]
        ]);
    }
}
