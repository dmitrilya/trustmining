<?php

namespace App\Console\Commands;

use App\Models\Coin;
use Illuminate\Console\Command;

class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchangerates:update';

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
        $key = config('services.coinmarketcap.key');
        $coins = Coin::where('paymentable', false)->pluck('abbreviation');
        $data = collect(json_decode(file_get_contents('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=' . $key . '&symbol=' . $coins->implode(',')))->data);
        $data->each(fn($coin) => Coin::where('abbreviation', $coin->symbol)->update(['rate' => $coin->quote->USD->price]));

        return Command::SUCCESS;
    }
}
