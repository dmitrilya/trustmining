<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

use App\Models\Database\AsicModel;
use App\Models\Database\Algorithm;
use App\Models\Database\Coin;
use App\Models\Morph\View;

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
        // $key = config('services.coinmarketcap.key');
        // $coins = Coin::where('paymentable', false)->pluck('abbreviation');
        // $data = collect(json_decode(file_get_contents('https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=' . $key . '&symbol=' . $coins->implode(',')))->data);
        // $data->each(function ($coinData) {
        //     $coin = Coin::where('abbreviation', $coinData->symbol)->first();
        //     if (!$coin || !$coinData->quote->USD->price) return;

        //     $coin->coinRates()->create(['rate' => $coinData->quote->USD->price]);
        // });

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        // curl_setopt($curl, CURLOPT_URL, 'https://api.coingecko.com/api/v3/exchange_rates');
        // curl_setopt($curl, CURLOPT_HTTPHEADER, [
        //     'x-cg-demo-api-key:' . config('services.coingecko.key'),
        //     'User-Agent: TrustMining/1.0 (contact: admin@trustmining.ru)',
        //     'accept: application/json',
        // ]);

        // $out = curl_exec($curl);

        // if ($out === false) info(curl_error($curl) . ', ' . curl_errno($curl));
        // else {
        //     $rates = json_decode($out)->rates;

        //     $btcRate = Coin::where('abbreviation', 'BTC')->first('id')->rate;
        //     Coin::where('abbreviation', 'RUB')->first('id')->coinRates()->create(['rate' => $btcRate / $rates->rub->value]);
        //     Coin::where('abbreviation', 'CNY')->first('id')->coinRates()->create(['rate' => $btcRate / $rates->cny->value]);
        // }

        $this->updateProfit();

        return Command::SUCCESS;
    }

    private function updateProfit()
    {
        $measurements = ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z'];
        $algorithms = Algorithm::select(['id', 'name'])->with([
            'coins' => fn($q) => $q->where('profit', '>', 0)->whereHas('latestRate', fn($q1) => $q1->where('rate', '>', 0))
                ->select(['id', 'abbreviation', 'name', 'algorithm_id', 'profit', 'merged_group', 'fee'])
        ])->get()->map(function ($algorithm) {
            $algorithm['maxProfit'] = $algorithm->coins->groupBy('merged_group')->map(
                fn($mergedGroup) => [
                    'profit' => $mergedGroup->sum(fn($coin) => $coin->profit * $coin->rate),
                    'coins' => $mergedGroup,
                ]
            )->sortByDesc('profit')->values();

            return $algorithm;
        });

        $models = AsicModel::select(['id', 'name', 'slug', 'algorithm_id', 'asic_brand_id', 'release'])->with([
            'algorithm:id,name,slug,measurement',
            'asicBrand:id,name,slug',
            'asicVersions:id,hashrate,asic_model_id,efficiency,measurement',
            'asicVersions.ads:asic_version_id,price,coin_id,props,user_id',
            'asicVersions.ads.coin:id,abbreviation',
            'asicVersions.ads.user:id,name',
            'moderatedReviews:reviewable_id,reviewable_type,rating'
        ])->get()->map(function ($model) use ($measurements, $algorithms) {
            $algorithm = $algorithms->where('id', $model->algorithm->id)->first();
            $am = in_array(strtolower($model->algorithm->measurement), ['h', 'sol', 'g', 'c', 'k']) ? 0 :
                array_search(substr($model->algorithm->measurement, 0, 1), $measurements);

            $model->asicVersions->map(function ($version) use ($measurements, $algorithm, $am, $model) {
                $ads = $version->ads->where('price', '!=', 0)->map(function ($ad) {
                    $ad->usdt_price = round($ad->price * $ad->coin->rate, 2);
                    return $ad;
                });
                $minPrice = $ads->sortBy('usdt_price')->first();
                $priceData = [
                    'New' => ['In stock' => null, 'Preorder' => null],
                    'Used' => ['In stock' => null, 'Preorder' => null],
                ];
                foreach ($ads->groupBy(['props.Condition', 'props.Availability']) as $condition => $conditionAds) {
                    foreach ($conditionAds as $availbility => $groupedAds) {
                        $prices = $groupedAds->pluck('usdt_price')->sort()->values();

                        if ($prices->count() < 4) {
                            $priceData[$condition][$availbility] = ['min' => $prices->min(), 'max' => $prices->max(), 'average' => $prices->avg()];
                            continue;
                        }

                        $q1 = $prices->get(floor($prices->count() * 0.25));
                        $q3 = $prices->get(floor($prices->count() * 0.75));
                        $iqr = $q3 - $q1;

                        $lowerBound = $q1 - (1.5 * $iqr);
                        $upperBound = $q3 + (1.5 * $iqr);

                        $average = $prices->filter(fn($p) => $p >= $lowerBound && $p <= $upperBound)->avg();

                        $priceData[$condition][$availbility] = ['min' => $prices->min(), 'max' => $prices->max(), 'lower_bound' => $lowerBound, 'upper_bound' => $upperBound, 'average' => $average];
                    }
                }
                $version->price_data = $priceData;
                $vm = in_array(strtolower($version->measurement), ['h', 'sol', 'g', 'c', 'k']) ? 0 :
                    array_search(substr($version->measurement, 0, 1), $measurements);
                $version->coef = pow(1000, $vm - $am);
                $version->profits = $algorithm->maxProfit->map(fn($profit) => [
                    'profit' => round($profit['profit'] * $version->hashrate * $version->coef, 4),
                    'coins' => $profit['coins']
                ]);
                $version->original_hashrate = $version->hashrate * pow(1000, $vm);
                $version->original_efficiency = $version->efficiency * pow(1000, $am - $vm);
                $version->price = $minPrice ? $minPrice->usdt_price : null;
                $version->seller = $minPrice ? $minPrice->user->name : null;
                $version->algorithm_id = $model->algorithm->id;
                $version->algorithm = $model->algorithm->name;
                $version->brand_name = $model->asicBrand->name;
                $version->brand_slug = $model->asicBrand->slug;
                $version->model_name = $model->name;
                $version->model_slug = $model->slug;
                $version->reviews_count = $model->moderatedReviews->count();
                $version->reviews_avg = $model->moderatedReviews->avg('rating');

                return $version;
            });

            return $model;
        });

        Cache::put('calculator_models', $models);

        $models = $models->map(fn($model) => [
            'i' => $model->id,
            'n' => $model->name,
            's' => $model->slug,
            'b' => $model->asicBrand->name,
            'bs' => $model->asicBrand->slug,
            'r' => $model->moderatedReviews->count(),
            'ra' => $model->moderatedReviews->avg('rating'),
            'v' => $model->asicVersions->map(fn($v) => [
                'i' => $v->id,
                'h' => $v->hashrate,
                'e' => $v->efficiency,
                'm' => $v->measurement,
                'c' => $v->coef,
                'p' => $v->price,
                's' => $v->seller,
                'a' => $v->algorithm_id,
                'ac' => count($v->ads),
            ])->toArray()
        ])->keyBy('i');


        $algorithms = $algorithms->map(fn($a) => [
            'i' => $a->id,
            'n' => $a->name,
            'p' => $a->maxProfit->map(fn($p) => [
                'p' => $p['profit'],
                'c' => $p['coins']->map(fn($c) => [
                    'n' => $c->name,
                    'a' => $c->abbreviation,
                    'p' => $c->profit,
                    'f' => $c->fee
                ])
            ])
        ])->keyBy('i');

        Cache::put('optimized_calculator_data', [
            'm' => $models,
            'p' => View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(30)->pluck('viewable_id'),
            'a' => $algorithms,
            'r' => Coin::where('abbreviation', 'RUB')->first('id')->rate
        ]);
    }
}
