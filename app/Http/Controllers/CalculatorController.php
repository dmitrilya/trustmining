<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewBlade;

use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Database\Coin;
use App\Models\Morph\View;

class CalculatorController extends Controller
{
    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $models = Cache::get('calculator_models');

        if ($asicModel && $asicModel->exists) $this->addView(request(), $asicModel);

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();
        $ads = $this->getAds()->where('asic_models.id', $selModel->id)
            ->orderByRaw('ads.price = 0')->orderByRaw("ads.price * coin_rates.rate")->limit(9)->get();

        $models = $models->map(fn($model) => [
            'id' => $model->id,
            'name' => $model->name,
            'asic_versions' => $model->asicVersions->map(function ($version) {
                $versionData = $version->toArray();
                $versionData['ads_count'] = count($version->ads);
                unset($versionData['ads']);
                unset($versionData['price_data']);
                unset($versionData['asic_model_id']);
                unset($versionData['original_hashrate']);
                unset($versionData['original_efficiency']);
                unset($versionData['brand_name']);
                $versionData['profits'] = $versionData['profits']->map(fn($profit) => [
                    'profit' => $profit['profit'],
                    'coins' => $profit['coins']->map(fn($coin) => $coin->only(['name', 'abbreviation', 'profit']))->toArray()
                ])->toArray();

                return $versionData;
            })->toArray()
        ]);

        return view('calculator.index', [
            'models' => $models,
            'popularModels' => $models->whereIn('id', View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(30)->pluck('viewable_id')),
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'ads' => $ads
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $models = Cache::get('calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();

        return view('calculator.app', [
            'models' => $models->map(fn($model) => [
                'id' => $model->id,
                'name' => $model->name,
                'asic_versions' => $model->asicVersions->map(function ($version) {
                    $versionData = $version->toArray();
                    $versionData['ads_count'] = count($version->ads);
                    unset($versionData['ads']);
                    unset($versionData['price_data']);
                    unset($versionData['asic_model_id']);
                    unset($versionData['original_hashrate']);
                    unset($versionData['original_efficiency']);
                    unset($versionData['brand_name']);
                    $versionData['profits'] = $versionData['profits']->map(fn($profit) => [
                        'profit' => $profit['profit'],
                        'coins' => $profit['coins']->map(fn($coin) => $coin->only(['name', 'abbreviation', 'profit']))->toArray()
                    ])->toArray();

                    return $versionData;
                })->toArray()
            ]),
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
        ]);
    }

    public function calculatorWidjet(Request $request): ViewBlade
    {
        $models = Cache::get('calculator_models');

        if ($request->model) {
            $selModel = $asicModel = $models->where('slug', $request->model)->first();
            if (!$selModel) $selModel = $models->where('name', 'Antminer L9')->first();
        } else {
            $asicModel = null;
            $selModel = $models->where('name', 'Antminer L9')->first();
        }

        if ($request->version) {
            $selVersion = $asicVersion = $selModel->asicVersions->where('hashrate', $request->version)->first();
            if (!$selVersion) $selVersion = $selModel->asicVersions->first();
        } else {
            $asicVersion = null;
            $selVersion = $selModel->asicVersions->first();
        }

        return view('calculator.widjet', [
            'models' => $models->map(fn($model) => [
                'id' => $model->id,
                'name' => $model->name,
                'asic_versions' => $model->asicVersions->map(function ($version) {
                    $versionData = $version->toArray();
                    $versionData['ads_count'] = count($version->ads);
                    unset($versionData['ads']);
                    unset($versionData['price_data']);
                    unset($versionData['asic_model_id']);
                    unset($versionData['original_hashrate']);
                    unset($versionData['original_efficiency']);
                    unset($versionData['brand_name']);
                    $versionData['profits'] = $versionData['profits']->map(fn($profit) => [
                        'profit' => $profit['profit'],
                        'coins' => $profit['coins']->map(fn($coin) => $coin->only(['name', 'abbreviation', 'profit']))->toArray()
                    ])->toArray();

                    return $versionData;
                })->toArray()
            ]),
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'blocks' => explode(',', $request->blocks),
            'theme' => $request->theme,
        ]);
    }

    public function calculatorModels()
    {
        return response()->json(Cache::get('calculator_models'), 200);
    }
}
