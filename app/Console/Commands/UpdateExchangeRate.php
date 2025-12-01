<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;

use App\Models\Database\AsicModel;
use App\Models\Database\Algorithm;
use App\Models\Database\Coin;

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

        $this->updateProfit();

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

        $rates = json_decode($out)->rates;

        $btcRate = Coin::where('abbreviation', 'BTC')->first('rate')->rate;
        Coin::where('abbreviation', 'RUB')->update(['rate' => $btcRate / $rates->rub->value]);
        Coin::where('abbreviation', 'CNY')->update(['rate' => $btcRate / $rates->cny->value]);

        return Command::SUCCESS;
    }

    private function updateProfit()
    {
        $measurements = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];
        $algorithms = Algorithm::select(['id'])->with([
            'coins' => fn($q) => $q->where('profit', '>', 0)->where('rate', '>', 0)
                ->select(['abbreviation', 'name', 'algorithm_id', 'profit', 'rate', 'merged_group'])
        ])->get()->map(function ($algorithm) {
            $algorithm['maxProfit'] = $algorithm->coins->groupBy('merged_group')->map(
                fn($mergedGroup) => [
                    'profit' => $mergedGroup->sum(fn($coin) => $coin->profit * $coin->rate),
                    'coins' => $mergedGroup
                ]
            )->sortByDesc('profit')->values();

            return $algorithm;
        });

        $models = AsicModel::select(['id', 'name', 'algorithm_id', 'asic_brand_id'])->with([
            'algorithm:id,name,measurement',
            'asicBrand:id,name',
            'asicVersions:id,hashrate,asic_model_id,efficiency,measurement',
            'asicVersions.ads:asic_version_id,price,coin_id',
            'asicVersions.ads.coin:id,rate,abbreviation',
            'moderatedReviews:reviewable_id,reviewable_type,rating'
        ])->get()->map(function ($model) use ($measurements, $algorithms) {
            $algorithm = $algorithms->where('id', $model->algorithm->id)->first();

            $model->asicVersions->map(function ($version) use ($measurements, $algorithm, $model) {
                $vm = array_search($version->measurement, $measurements);
                $am = array_search($model->algorithm->measurement, $measurements);
                $version->profits = $algorithm->maxProfit->map(fn($profit) => [
                    'profit' => round($profit['profit'] * $version->hashrate * pow(1000, $vm - $am), 4),
                    'coins' => $profit['coins']
                ]);
                $version->price = round($version->ads->avg(fn($ad) => $ad->price * $ad->coin->rate), 2);
                $version->algorithm = $model->algorithm->name;
                $version->brand_name = strtolower(str_replace(' ', '_', $model->asicBrand->name));
                $version->model_name = strtolower(str_replace(' ', '_', $model->name));
                $version->reviews_count = $model->moderatedReviews->count();
                $version->reviews_avg = $model->moderatedReviews->avg('rating');

                return $version;
            });

            return $model;
        });

        Cache::put('calculator_models', $models);
    }
}
