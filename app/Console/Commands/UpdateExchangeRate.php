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

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_URL, 'https://api.coingecko.com/api/v3/exchange_rates');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'x-cg-demo-api-key:' . config('services.coingecko.key'),
            'accept: application/json',
        ]);

        $out = curl_exec($curl);

        if ($out === false) dump(curl_error($curl), curl_errno($curl));
        
        curl_close($curl);

        $rates = json_decode($out)->rates;

        $btcRate = Coin::where('abbreviation', 'BTC')->first('rate')->rate;
        Coin::where('abbreviation', 'RUB')->update(['rate' => $btcRate / $rates->rub]);
        Coin::where('abbreviation', 'CNY')->update(['rate' => $btcRate / $rates->cny]);

        return Command::SUCCESS;
    }
}
