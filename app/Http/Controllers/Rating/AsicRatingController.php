<?php

namespace App\Http\Controllers\Rating;

use App\Enums\CoolingType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use App\Http\Traits\AdTrait;
use App\Models\Ad\AdCategory;
use App\Models\Database\Coin;

class AsicRatingController extends Controller
{
    use AdTrait;

    protected array $coins;
    protected array $algos;
    protected array $coolings;
    protected array $prices;

    public function __construct()
    {
        $this->coins = [
            ['n' => 'Bitcoin', 'a' => 'BTC'],
            ['n' => 'Litecoin', 'a' => 'LTC'],
            ['n' => 'Kaspa', 'a' => 'KAS'],
            ['n' => 'Zcash', 'a' => 'ZEC'],
        ];

        $this->algos = ['SHA-256', 'Scrypt', 'kHeavyHash', 'Equihash', 'Etchash'];

        $this->coolings = [['slug' => 'air', 'n' => __('Air')], ['slug' => 'hydro', 'n' => __('Hydro')], ['slug' => 'immersion', 'n' => __('Immersion')]];

        $this->prices = [
            ['slug' => '50000', 'n' => __('Up to') . ' 50 000 ₽'],
            ['slug' => '100000', 'n' => __('Up to') . ' 100 000 ₽'],
            ['slug' => '200000', 'n' => __('Up to') . ' 200 000 ₽'],
        ];
    }

    public function index(): View
    {
        return view('rating.asics.index', [
            'data' => Cache::get('home_page_data'),
            'coins' => $this->coins,
            'algos' => $this->algos,
            'coolings' => $this->coolings,
            'prices' => $this->prices,
        ]);
    }

    public function show(string $type, ?string $filter = null): View
    {
        $data = Cache::get('optimized_calculator_data');

        $models = collect($data['m']);
        $algos = collect($data['a']);
        $rub = $data['r'];
        $filterType = null;
        $filterValue = null;
        $coinAlgoId = null;

        if ($filter) {
            $parts = explode('-', $filter, 2);

            if (!(count($parts) === 2 || (count($parts) === 1 && in_array($parts[0], ['home', 'new'])))) abort(404);

            $filterType = $parts[0];

            if (!in_array($filterType, ['algorithm', 'coin', 'price', 'cooling', 'home', 'new'])) abort(404);

            $filterValue = $parts[1] ?? null;

            if ($filterType == 'coin') {
                $coinAlgoId = Coin::where('name', $filterValue)->first('algorithm_id')->algorithm()->value('id');
                if (!$coinAlgoId) abort(404);
            }
        }

        $models = $models->filter(function ($model) use ($algos, $type, $filterType, $filterValue, $coinAlgoId, $rub) {
            $algoData = $algos->get($model['a']);

            if (!$algoData || !count($algoData['p'])) return false;

            if ($filterType == 'algorithm' && strtolower($algoData['n']) != $filterValue) return false;
            if ($filterType == 'coin' && $model['a'] != $coinAlgoId) return false;
            if ($filterType == 'cooling' && strtolower(CoolingType::from($model['c'])->name) != $filterValue) return false;
            if ($filterType == 'new' && !$model['m']) return false;

            $versions = collect($model['v']);

            if ($filterType == 'home' && $versions->first()['h'] * $versions->first()['e'] > 1200) return false;
            if ($type == 'payback' || $filterType == 'price') $versions = $versions->filter(fn($v) => isset($v['p']) && $v['p'] > 0);

            if ($versions->isEmpty()) return false;

            if ($filterType == 'price') $versions = $versions->filter(fn($v) => $v['p'] <= $filterValue * $rub);

            if ($versions->isEmpty()) return false;

            return true;
        });

        if ($type == 'payback') $models = $models->map(function ($model) use ($filterType, $filterValue, $algos, $rub) {
            $algoProfit = $algos->get($model['a'])['p'][0]['p'];

            $version = collect($model['v'])->filter(function ($v) use ($filterType, $filterValue, $rub) {
                $hasPrice = isset($v['p']) && $v['p'] > 0;

                return $filterType != 'price' ? $hasPrice : $hasPrice && $v['p'] <= $filterValue * $rub;
            })->map(function ($v) use ($algoProfit, $rub) {
                $income = $v['h'] * $v['c'] * $algoProfit;
                $consumption = $v['e'] * $v['h'] / 1000 * 3.5 * 24 * $rub;
                $profit = $income - $consumption;
                $v['pb'] = $profit > 0 ? $v['p'] / $profit : 99999;

                return $v;
            })->sortBy('pb')->first();

            $model['v'] = $version;

            return $model;
        })->sortBy('v.pb');
        elseif ($type == 'profit') $models = $models->map(function ($model) use ($filterType, $filterValue, $algos, $rub) {
            $model['v'] = $filterType != 'price' ? $model['v'][0] : collect($model['v'])->filter(fn($v) => isset($v['p']) && $v['p'] > 0 && $v['p'] <= $filterValue * $rub)->first();

            return $model;
        })->sortByDesc(fn($m) => $algos->get($m['a'])['p'][0]['p'] * $m['v']['h'] * $m['v']['c']);

        $models = $models->take(40)->values();
        $ads = $this->getAds(AdCategory::where('name', 'miners')->value('id'))->whereIn('asic_models.id', $models->take(5)->pluck('id'))->orderByDesc('ads.ordering_id')->limit(14)->get();

        if ($filter) {
            $value = $filterValue;
            if ($filterType == 'cooling') $value = __("meta.rating.asics.filters.cooling.{$filterValue}.title");
            $title = __("meta.rating.asics.filters.{$filterType}.title", ['prefix' => __("meta.rating.asics.types.{$type}.title_prefix"), 'filter_value' => $value]);
            if ($filterType == 'cooling') $value = __("meta.rating.asics.filters.cooling.{$filterValue}.description");
            $description = __("meta.rating.asics.filters.{$filterType}.description", ['prefix' => __("meta.rating.asics.types.{$type}.header_prefix"), 'filter_value' => $value]);
            if ($filterType == 'cooling') $value = __("meta.rating.asics.filters.cooling.{$filterValue}.header");
            $header = __("meta.rating.asics.filters.{$filterType}.header", ['prefix' => __("meta.rating.asics.types.{$type}.header_prefix"), 'filter_value' => $value]);
        } else {
            $title = __("meta.rating.asics.types.{$type}.title", ['year' => now()->year]);
            $description = __("meta.rating.asics.types.{$type}.description");
            $header = __("meta.rating.asics.types.{$type}.header");
        }

        return view('rating.asics.show', [
            'type' => $type,
            'filterType' => $filterType,
            'filterValue' => $filterValue,
            'models' => $models,
            'ads' => $ads,
            'algorithms' => $algos,
            'rub' => $rub,
            'title' => $title,
            'description' => $description,
            'header' => $header,
            'coins' => $this->coins,
            'algos' => $this->algos,
            'coolings' => $this->coolings,
            'prices' => $this->prices,
        ]);
    }
}
