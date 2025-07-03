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
            ["name" => "USDT", "abbreviation" => "USDT", "algorithm_id" => null, "paymentable" => true],
            ["name" => "Ruble", "abbreviation" => "RUB", "algorithm_id" => null, "paymentable" => true],
            ["name" => "Renminbi", "abbreviation" => "CNY", "algorithm_id" => null, "paymentable" => true],
            ["name" => "Bitcoin", "abbreviation" => "BTC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Dogecoin", "abbreviation" => "DOGE", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "BitcoinCash", "abbreviation" => "BCH", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Litecoin", "abbreviation" => "LTC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Monero", "abbreviation" => "XMR", "algorithm_id" => $algos->where("name", "RandomX")->first()->id, "paymentable" => false],
            ["name" => "Ethereum Classic", "abbreviation" => "ETC", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "Kaspa", "abbreviation" => "KAS", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false],
            ["name" => "Zcash", "abbreviation" => "ZEC", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false],
            ["name" => "MimbleWimble", "abbreviation" => "MWC", "algorithm_id" => $algos->where("name", "Cuckatoo31")->first()->id, "paymentable" => false],
            ["name" => "eCash", "abbreviation" => "XEC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Conflux", "abbreviation" => "CFX", "algorithm_id" => $algos->where("name", "Octopus")->first()->id, "paymentable" => false],
            ["name" => "Dash", "abbreviation" => "DASH", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false],
            ["name" => "Ravencoin", "abbreviation" => "RVN", "algorithm_id" => $algos->where("name", "KawPow")->first()->id, "paymentable" => false],
            ["name" => "SiaCoin", "abbreviation" => "SC", "algorithm_id" => $algos->where("name", "Blake2B-Sia")->first()->id, "paymentable" => false],
            ["name" => "Nervos", "abbreviation" => "CKB", "algorithm_id" => $algos->where("name", "Eaglesong")->first()->id, "paymentable" => false],
            ["name" => "ETHPoW", "abbreviation" => "ETHW", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "DigiByte", "abbreviation" => "DGB", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Kadena", "abbreviation" => "KDA", "algorithm_id" => $algos->where("name", "Kadena")->first()->id, "paymentable" => false],
            ["name" => "Horizen", "abbreviation" => "ZEN", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false],
            ["name" => "Aleo", "abbreviation" => "ALEO", "algorithm_id" => $algos->where("name", "zkSNARK")->first()->id, "paymentable" => false],
            ["name" => "Alephium", "abbreviation" => "ALPH", "algorithm_id" => $algos->where("name", "Blake3")->first()->id, "paymentable" => false],
            ["name" => "Groestlcoin", "abbreviation" => "GRS", "algorithm_id" => $algos->where("name", "Groestl")->first()->id, "paymentable" => false],
            ["name" => "Fractal Bitcoin", "abbreviation" => "FB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "PepeCoin", "abbreviation" => "PEP", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "OctaSpace", "abbreviation" => "OCGTA", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "Komodo", "abbreviation" => "KMD", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false],
            ["name" => "Monacoin", "abbreviation" => "MONA", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false],
            ["name" => "Peercoin", "abbreviation" => "PPC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Zephyr", "abbreviation" => "ZEPH", "algorithm_id" => $algos->where("name", "RandomX")->first()->id, "paymentable" => false],
            ["name" => "Nexa", "abbreviation" => "NEXA", "algorithm_id" => $algos->where("name", "NexaPow")->first()->id, "paymentable" => false],
            ["name" => "Vertcoin", "abbreviation" => "VTC", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false],
            ["name" => "Luckycoin", "abbreviation" => "LKY", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Handshake", "abbreviation" => "HNS", "algorithm_id" => $algos->where("name", "Handshake")->first()->id, "paymentable" => false],
            ["name" => "Bytecoin", "abbreviation" => "BCN", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false],
            ["name" => "Grin", "abbreviation" => "GRIN", "algorithm_id" => $algos->where("name", "Cuckatoo32")->first()->id, "paymentable" => false],
            ["name" => "DingoCoin", "abbreviation" => "DINGO", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "ScPrime", "abbreviation" => "SCP", "algorithm_id" => $algos->where("name", "Blake256R14")->first()->id, "paymentable" => false],
            ["name" => "Radiant", "abbreviation" => "RXD", "algorithm_id" => $algos->where("name", "SHA512256d")->first()->id, "paymentable" => false],
            ["name" => "Catcoin", "abbreviation" => "CAT", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "LBRY", "abbreviation" => "LBC", "algorithm_id" => $algos->where("name", "Lbry")->first()->id, "paymentable" => false],
            ["name" => "Junkcoin", "abbreviation" => "JKC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Sedra", "abbreviation" => "SDR", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false],
            ["name" => "Hush", "abbreviation" => "HUSH", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false],
            ["name" => "Bugna", "abbreviation" => "BGA", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false],
            ["name" => "Acoin", "abbreviation" => "ACOIN", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Aeon", "abbreviation" => "AEON", "algorithm_id" => $algos->where("name", "CryptoNight-LiteV1")->first()->id, "paymentable" => false],
            ["name" => "Auroracoin", "abbreviation" => "AUR", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Axe", "abbreviation" => "AXE", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false],
            ["name" => "Bells", "abbreviation" => "BEL", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "BitcoinSV", "abbreviation" => "BSV", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "BlocX", "abbreviation" => "BLOCX", "algorithm_id" => $algos->where("name", "Autolykos")->first()->id, "paymentable" => false],
            ["name" => "Bulwark", "abbreviation" => "BWK", "algorithm_id" => $algos->where("name", "Nist5")->first()->id, "paymentable" => false],
            ["name" => "Bytom", "abbreviation" => "BTM", "algorithm_id" => $algos->where("name", "Tensority")->first()->id, "paymentable" => false],
            ["name" => "Callisto", "abbreviation" => "CLO", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "DigitalpriceClassic", "abbreviation" => "DPC", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false],
            ["name" => "Electroneum", "abbreviation" => "ETN", "algorithm_id" => $algos->where("name", "Cryptonight-V7")->first()->id, "paymentable" => false],
            ["name" => "Emerald", "abbreviation" => "EMD", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "EtherGem", "abbreviation" => "EGEM", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "GainProX", "abbreviation" => "GPRX", "algorithm_id" => $algos->where("name", "GhostRider")->first()->id, "paymentable" => false],
            ["name" => "Galactrum", "abbreviation" => "ORE", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false],
            ["name" => "GoldCoin", "abbreviation" => "GLC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false],
            ["name" => "Karbo", "abbreviation" => "KRB", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false],
            ["name" => "Lethean", "abbreviation" => "LTHN", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id, "paymentable" => false],
            ["name" => "Monero Original", "abbreviation" => "XMO", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false],
            ["name" => "MonetaryUnit", "abbreviation" => "MUE", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false],
            ["name" => "Myriad-Groestl", "abbreviation" => "XMY", "algorithm_id" => $algos->where("name", "Myriad-Groestl")->first()->id, "paymentable" => false],
            ["name" => "Namecoin", "abbreviation" => "NMC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Onix", "abbreviation" => "ONX", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false],
            ["name" => "PascalCoin", "abbreviation" => "PASC", "algorithm_id" => $algos->where("name", "Pascal")->first()->id, "paymentable" => false],
            ["name" => "PascalLite", "abbreviation" => "PASL", "algorithm_id" => $algos->where("name", "Pascal")->first()->id, "paymentable" => false],
            ["name" => "Quai", "abbreviation" => "QUAI", "algorithm_id" => $algos->where("name", "ProgPow")->first()->id, "paymentable" => false],
            ["name" => "QuarkChain", "abbreviation" => "QKC", "algorithm_id" => $algos->where("name", "EtHash")->first()->id, "paymentable" => false],
            ["name" => "SiaClassic", "abbreviation" => "SCC", "algorithm_id" => $algos->where("name", "Blake2B")->first()->id, "paymentable" => false],
            ["name" => "Sibcoin", "abbreviation" => "SIB", "algorithm_id" => $algos->where("name", "X11Gost")->first()->id, "paymentable" => false],
            ["name" => "Stratis", "abbreviation" => "STRAT", "algorithm_id" => $algos->where("name", "X13")->first()->id, "paymentable" => false],
            ["name" => "Sumokoin", "abbreviation" => "SUMO", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id, "paymentable" => false],
            ["name" => "Terracoin", "abbreviation" => "TRC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "Unbreakable", "abbreviation" => "UNB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false],
            ["name" => "eMark", "abbreviation" => "DEM", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false]
        ]);
    }
}
