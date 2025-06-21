<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $algorithms = collect(json_decode(file_get_contents('https://pool.binance.com/mining-api/v1/public/pool/index'))->data->algoList)->pluck('symbolInfos', 'algoName');

        foreach ($algorithms as $algorithm) {
            foreach ($algorithm as $symbolInfo) {
                Coin::where('name', $symbolInfo->symbol)->update(['profit' => $symbolInfo->eachEarn]);

                if ($symbolInfo->eachEarnMap)
                    foreach ($symbolInfo->eachEarnMap as $coinId => $coinProfit) {
                        Coin::where('id', $coinId)->update(['profit' => $coinProfit]);
                    }
            }
        }

        return Command::SUCCESS;
    }
}
