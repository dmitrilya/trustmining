<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Algorithm;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $algos = Algorithm::all();

        \DB::table('coins')->insert([
            ["name" => "Bitcoin", "abbreviation" => "BTC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Dogecoin", "abbreviation" => "DOGE", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "BitcoinCash", "abbreviation" => "BCH", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Litecoin", "abbreviation" => "LTC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Monero", "abbreviation" => "XMR", "algorithm_id" => $algos->where("name", "RandomX")->first()->id],
            ["name" => "Ethereum Classic", "abbreviation" => "ETC", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "Kaspa", "abbreviation" => "KAS", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id],
            ["name" => "Zcash", "abbreviation" => "ZEC", "algorithm_id" => $algos->where("name", "Equihash")->first()->id],
            ["name" => "MimbleWimble", "abbreviation" => "MWC", "algorithm_id" => $algos->where("name", "Cuckatoo31")->first()->id],
            ["name" => "eCash", "abbreviation" => "XEC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Conflux", "abbreviation" => "CFX", "algorithm_id" => $algos->where("name", "Octopus")->first()->id],
            ["name" => "Dash", "abbreviation" => "DASH", "algorithm_id" => $algos->where("name", "X11")->first()->id],
            ["name" => "Ravencoin", "abbreviation" => "RVN", "algorithm_id" => $algos->where("name", "KawPow")->first()->id],
            ["name" => "SiaCoin", "abbreviation" => "SC", "algorithm_id" => $algos->where("name", "Blake2B-Sia")->first()->id],
            ["name" => "Nervos", "abbreviation" => "CKB", "algorithm_id" => $algos->where("name", "Eaglesong")->first()->id],
            ["name" => "ETHPoW", "abbreviation" => "ETHW", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "DigiByte", "abbreviation" => "DGB", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Kadena", "abbreviation" => "KDA", "algorithm_id" => $algos->where("name", "Kadena")->first()->id],
            ["name" => "Horizen", "abbreviation" => "ZEN", "algorithm_id" => $algos->where("name", "Equihash")->first()->id],
            ["name" => "Aleo", "abbreviation" => "ALEO", "algorithm_id" => $algos->where("name", "zkSNARK")->first()->id],
            ["name" => "Alephium", "abbreviation" => "ALPH", "algorithm_id" => $algos->where("name", "Blake3")->first()->id],
            ["name" => "Groestlcoin", "abbreviation" => "GRS", "algorithm_id" => $algos->where("name", "Groestl")->first()->id],
            ["name" => "Fractal Bitcoin", "abbreviation" => "FB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "PepeCoin", "abbreviation" => "PEP", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "OctaSpace", "abbreviation" => "OCGTA", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "Komodo", "abbreviation" => "KMD", "algorithm_id" => $algos->where("name", "Equihash")->first()->id],
            ["name" => "Monacoin", "abbreviation" => "MONA", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id],
            ["name" => "Peercoin", "abbreviation" => "PPC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Zephyr", "abbreviation" => "ZEPH", "algorithm_id" => $algos->where("name", "RandomX")->first()->id],
            ["name" => "Nexa", "abbreviation" => "NEXA", "algorithm_id" => $algos->where("name", "NexaPow")->first()->id],
            ["name" => "Vertcoin", "abbreviation" => "VTC", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id],
            ["name" => "Luckycoin", "abbreviation" => "LKY", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Handshake", "abbreviation" => "HNS", "algorithm_id" => $algos->where("name", "Handshake")->first()->id],
            ["name" => "Bytecoin", "abbreviation" => "BCN", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id],
            ["name" => "Grin", "abbreviation" => "GRIN", "algorithm_id" => $algos->where("name", "Cuckatoo32")->first()->id],
            ["name" => "DingoCoin", "abbreviation" => "DINGO", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "ScPrime", "abbreviation" => "SCP", "algorithm_id" => $algos->where("name", "Blake256R14")->first()->id],
            ["name" => "Radiant", "abbreviation" => "RXD", "algorithm_id" => $algos->where("name", "SHA512256d")->first()->id],
            ["name" => "Catcoin", "abbreviation" => "CAT", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "LBRY", "abbreviation" => "LBC", "algorithm_id" => $algos->where("name", "Lbry")->first()->id],
            ["name" => "Junkcoin", "abbreviation" => "JKC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Sedra", "abbreviation" => "SDR", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id],
            ["name" => "Hush", "abbreviation" => "HUSH", "algorithm_id" => $algos->where("name", "Equihash")->first()->id],
            ["name" => "Bugna", "abbreviation" => "BGA", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id],
            ["name" => "Acoin", "abbreviation" => "ACOIN", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Aeon", "abbreviation" => "AEON", "algorithm_id" => $algos->where("name", "CryptoNight-LiteV1")->first()->id],
            ["name" => "Auroracoin", "abbreviation" => "AUR", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Axe", "abbreviation" => "AXE", "algorithm_id" => $algos->where("name", "X11")->first()->id],
            ["name" => "Bells", "abbreviation" => "BEL", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "BitcoinSV", "abbreviation" => "BSV", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "BlocX", "abbreviation" => "BLOCX", "algorithm_id" => $algos->where("name", "Autolykos")->first()->id],
            ["name" => "Bulwark", "abbreviation" => "BWK", "algorithm_id" => $algos->where("name", "Nist5")->first()->id],
            ["name" => "Bytom", "abbreviation" => "BTM", "algorithm_id" => $algos->where("name", "Tensority")->first()->id],
            ["name" => "Callisto", "abbreviation" => "CLO", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "DigitalpriceClassic", "abbreviation" => "DPC", "algorithm_id" => $algos->where("name", "X11")->first()->id],
            ["name" => "Electroneum", "abbreviation" => "ETN", "algorithm_id" => $algos->where("name", "Cryptonight-V7")->first()->id],
            ["name" => "Emerald", "abbreviation" => "EMD", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "EtherGem", "abbreviation" => "EGEM", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "GainProX", "abbreviation" => "GPRX", "algorithm_id" => $algos->where("name", "GhostRider")->first()->id],
            ["name" => "Galactrum", "abbreviation" => "ORE", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id],
            ["name" => "GoldCoin", "abbreviation" => "GLC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id],
            ["name" => "Karbo", "abbreviation" => "KRB", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id],
            ["name" => "Lethean", "abbreviation" => "LTHN", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id],
            ["name" => "Monero Original", "abbreviation" => "XMO", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id],
            ["name" => "MonetaryUnit", "abbreviation" => "MUE", "algorithm_id" => $algos->where("name", "X11")->first()->id],
            ["name" => "Myriad-Groestl", "abbreviation" => "XMY", "algorithm_id" => $algos->where("name", "Myriad-Groestl")->first()->id],
            ["name" => "Namecoin", "abbreviation" => "NMC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Onix", "abbreviation" => "ONX", "algorithm_id" => $algos->where("name", "X11")->first()->id],
            ["name" => "PascalCoin", "abbreviation" => "PASC", "algorithm_id" => $algos->where("name", "Pascal")->first()->id],
            ["name" => "PascalLite", "abbreviation" => "PASL", "algorithm_id" => $algos->where("name", "Pascal")->first()->id],
            ["name" => "Quai", "abbreviation" => "QUAI", "algorithm_id" => $algos->where("name", "ProgPow")->first()->id],
            ["name" => "QuarkChain", "abbreviation" => "QKC", "algorithm_id" => $algos->where("name", "EtHash")->first()->id],
            ["name" => "SiaClassic", "abbreviation" => "SCC", "algorithm_id" => $algos->where("name", "Blake2B")->first()->id],
            ["name" => "Sibcoin", "abbreviation" => "SIB", "algorithm_id" => $algos->where("name", "X11Gost")->first()->id],
            ["name" => "Stratis", "abbreviation" => "STRAT", "algorithm_id" => $algos->where("name", "X13")->first()->id],
            ["name" => "Sumokoin", "abbreviation" => "SUMO", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id],
            ["name" => "Terracoin", "abbreviation" => "TRC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "Unbreakable", "abbreviation" => "UNB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id],
            ["name" => "eMark", "abbreviation" => "DEM", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id]
        ]);
    }
}
