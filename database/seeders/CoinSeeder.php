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
            ["name" => "USDT", "abbreviation" => "USDT", "algorithm_id" => null, "paymentable" => true, "merged_group" => null],
            ["name" => "Ruble", "abbreviation" => "RUB", "algorithm_id" => null, "paymentable" => true, "merged_group" => null],
            ["name" => "Renminbi", "abbreviation" => "CNY", "algorithm_id" => null, "paymentable" => true, "merged_group" => null],
            ["name" => "Bitcoin", "abbreviation" => "BTC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Fractal Bitcoin", "abbreviation" => "FB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Litecoin", "abbreviation" => "LTC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Dogecoin", "abbreviation" => "DOGE", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Bellscoin", "abbreviation" => "BEL", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Pepecoin", "abbreviation" => "PEP", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Luckycoin", "abbreviation" => "LKY", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Junkcoin", "abbreviation" => "JKC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Dingocoin", "abbreviation" => "DINGO", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Bitcoin Cash", "abbreviation" => "BCH", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Monero", "abbreviation" => "XMR", "algorithm_id" => $algos->where("name", "RandomX")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Ethereum Classic", "abbreviation" => "ETC", "algorithm_id" => $algos->where("name", "ETCHash")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Kaspa", "abbreviation" => "KAS", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Zcash", "abbreviation" => "ZEC", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "MimbleWimbleCoin", "abbreviation" => "MWC", "algorithm_id" => $algos->where("name", "Cuckatoo31")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "eCash", "abbreviation" => "XEC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "Conflux", "abbreviation" => "CFX", "algorithm_id" => $algos->where("name", "Octopus")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Dash", "abbreviation" => "DASH", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Ravencoin", "abbreviation" => "RVN", "algorithm_id" => $algos->where("name", "KawPow")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Siacoin", "abbreviation" => "SC", "algorithm_id" => $algos->where("name", "Blake (2b-Sia)")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Nervos Network", "abbreviation" => "CKB", "algorithm_id" => $algos->where("name", "Eaglesong")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "EthereumPoW", "abbreviation" => "ETHW", "algorithm_id" => $algos->where("name", "Ethash")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "DigiByte (Qubit)", "abbreviation" => "DGB", "algorithm_id" => $algos->where("name", "Qubit")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Kadena", "abbreviation" => "KDA", "algorithm_id" => $algos->where("name", "Blake (2s-Kadena)")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Horizen", "abbreviation" => "ZEN", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "ALEO", "abbreviation" => "ALEO", "algorithm_id" => $algos->where("name", "zkSNARK")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Alephium", "abbreviation" => "ALPH", "algorithm_id" => $algos->where("name", "Blake3")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Groestlcoin", "abbreviation" => "GRS", "algorithm_id" => $algos->where("name", "Groestl")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "OctaSpace", "abbreviation" => "OCTA", "algorithm_id" => $algos->where("name", "ETCHash")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Komodo", "abbreviation" => "KMD", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "MonaCoin", "abbreviation" => "MONA", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Peercoin", "abbreviation" => "PPC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 4],
            ["name" => "Zephyr Protocol", "abbreviation" => "ZEPH", "algorithm_id" => $algos->where("name", "RandomX")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Nexa", "abbreviation" => "NEXA", "algorithm_id" => $algos->where("name", "NexaPow")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Vertcoin", "abbreviation" => "VTC", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Handshake", "abbreviation" => "HNS", "algorithm_id" => $algos->where("name", "Handshake")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Bytecoin", "abbreviation" => "BCN", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Grin", "abbreviation" => "GRIN", "algorithm_id" => $algos->where("name", "Cuckatoo32")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "ScPrime", "abbreviation" => "SCP", "algorithm_id" => $algos->where("name", "Blake (14r)")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Radiant", "abbreviation" => "RXD", "algorithm_id" => $algos->where("name", "SHA512256d")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Catcoin", "abbreviation" => "CAT", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "LBRY Credits", "abbreviation" => "LBC", "algorithm_id" => $algos->where("name", "Lbry")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Sedra Coin", "abbreviation" => "SDR", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Hush", "abbreviation" => "HUSH", "algorithm_id" => $algos->where("name", "Equihash")->first()->id, "paymentable" => false, "merged_group" => 4],
            ["name" => "Bugna", "abbreviation" => "BGA", "algorithm_id" => $algos->where("name", "KHeavyHash")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "Acoin", "abbreviation" => "ACOIN", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 5],
            ["name" => "Aeon", "abbreviation" => "AEON", "algorithm_id" => $algos->where("name", "CryptoNight-LiteV1")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Auroracoin", "abbreviation" => "AUR", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 4],
            ["name" => "Axe", "abbreviation" => "AXE", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "BitcoinSV", "abbreviation" => "BSV", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 6],
            ["name" => "BlocX", "abbreviation" => "BLOCX", "algorithm_id" => $algos->where("name", "Autolykos2")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Bulwark", "abbreviation" => "BWK", "algorithm_id" => $algos->where("name", "Nist5")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Bytom", "abbreviation" => "BTM", "algorithm_id" => $algos->where("name", "Tensority")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Callisto", "abbreviation" => "CLO", "algorithm_id" => $algos->where("name", "ETCHash")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "DigitalpriceClassic", "abbreviation" => "DPC", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "Electroneum", "abbreviation" => "ETN", "algorithm_id" => $algos->where("name", "Cryptonight-V7")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Emerald", "abbreviation" => "EMD", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 5],
            ["name" => "EtherGem", "abbreviation" => "EGEM", "algorithm_id" => $algos->where("name", "ETCHash")->first()->id, "paymentable" => false, "merged_group" => 4],
            ["name" => "GainProX", "abbreviation" => "GPRX", "algorithm_id" => $algos->where("name", "GhostRider")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Galactrum", "abbreviation" => "ORE", "algorithm_id" => $algos->where("name", "Lyra2REv2")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "Goldcoin", "abbreviation" => "GLC", "algorithm_id" => $algos->where("name", "Scrypt")->first()->id, "paymentable" => false, "merged_group" => 6],
            ["name" => "Karbo", "abbreviation" => "KRB", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Lethean", "abbreviation" => "LTHN", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Monero Original", "abbreviation" => "XMO", "algorithm_id" => $algos->where("name", "CryptoNight")->first()->id, "paymentable" => false, "merged_group" => 3],
            ["name" => "MonetaryUnit", "abbreviation" => "MUE", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false, "merged_group" => 4],
            ["name" => "Myriad", "abbreviation" => "XMY", "algorithm_id" => $algos->where("name", "Myr-Groestl")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Namecoin", "abbreviation" => "NMC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 7],
            ["name" => "Onix", "abbreviation" => "ONX", "algorithm_id" => $algos->where("name", "X11")->first()->id, "paymentable" => false, "merged_group" => 5],
            ["name" => "PascalCoin", "abbreviation" => "PASC", "algorithm_id" => $algos->where("name", "RandomHash2")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "PascalLite", "abbreviation" => "PASL", "algorithm_id" => $algos->where("name", "RandomHash2")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Quai", "abbreviation" => "QUAI", "algorithm_id" => $algos->where("name", "ProgPow")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "QuarkChain", "abbreviation" => "QKC", "algorithm_id" => $algos->where("name", "Ethash")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "SiaClassic", "abbreviation" => "SCC", "algorithm_id" => $algos->where("name", "Blake (2b)")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Sibcoin", "abbreviation" => "SIB", "algorithm_id" => $algos->where("name", "X11Gost")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Stratis", "abbreviation" => "STRAT", "algorithm_id" => $algos->where("name", "X13")->first()->id, "paymentable" => false, "merged_group" => 1],
            ["name" => "Sumokoin", "abbreviation" => "SUMO", "algorithm_id" => $algos->where("name", "CryptoNightR")->first()->id, "paymentable" => false, "merged_group" => 2],
            ["name" => "Terracoin", "abbreviation" => "TRC", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 8],
            ["name" => "Unbreakable", "abbreviation" => "UNB", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 9],
            ["name" => "eMark", "abbreviation" => "DEM", "algorithm_id" => $algos->where("name", "SHA-256")->first()->id, "paymentable" => false, "merged_group" => 10]
        ]);
    }
}
