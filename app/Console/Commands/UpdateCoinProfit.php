<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Algorithm;
use App\Models\Coin;

class UpdateCoinProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coinprofit:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $coinIds = [
        22 => 'FB',
        10 => 'DOGE',
        21 => 'BEL',
        23 => 'LKY',
        24 => 'PEP',
        25 => 'JKC'
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $mes = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];

        collect(json_decode(file_get_contents('https://api.minerstat.com/v2/coins?list=' . Coin::where('paymentable', false)->pluck('abbreviation')->implode(','))))
            ->each(function ($coin) use ($mes) {
                if ($coin->coin == 'GRIN') return;

                $coinData = [];
                if ($coin->algorithm == 'Radiant') $coin->algorithm = 'SHA512256d';
                if ($coin->algorithm == 'NexaHash') $coin->algorithm = 'NexaPow';
                
                $algorithm = Algorithm::where('name', $coin->algorithm)->first();
                if (!$algorithm) return;
                
                if ($coin->reward !== -1) $coinData['profit'] = $coin->reward * 24 * pow(1000, array_search($algorithm->measurement, $mes));
                if ($coin->difficulty !== -1) $coinData['difficulty'] = $coin->difficulty;
                if ($coin->reward_block !== -1) $coinData['reward_block'] = $coin->reward_block;

                if (count($coinData)) Coin::where('abbreviation', $coin->coin)->update($coinData);
            });

        collect(json_decode(file_get_contents('https://pool.binance.com/mining-api/v1/public/pool/index'))->data->algoList)
            ->pluck('symbolInfos', 'algoName')
            ->each(function ($algorithm) {
                foreach ($algorithm as $symbolInfo) {
                    Coin::where('abbreviation', $symbolInfo->symbol)->update(['profit' => $symbolInfo->eachEarn, 'difficulty' => $symbolInfo->difficulty]);

                    if ($symbolInfo->eachEarnMap) foreach ($symbolInfo->eachEarnMap as $coinId => $coinProfit) {
                        if (isset($this->coinIds[$coinId])) Coin::where('abbreviation', $this->coinIds[$coinId])->update(['profit' => $coinProfit]);
                        else info('Binance new merged coin: ' . $symbolInfo->symbol);
                    }
                }
            });

        return Command::SUCCESS;
    }
}
