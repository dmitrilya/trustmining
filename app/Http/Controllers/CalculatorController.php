<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewBlade;

use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;

class CalculatorController extends Controller
{
    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $models = Cache::get('optimized_calculator_models');

        if ($asicModel && $asicModel->exists) $this->addView(request(), $asicModel);

        $selModel = $asicModel && $asicModel->exists ? $models['all']->where('id', $asicModel->id)->first() : $models['all']->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['asic_versions'])->where('id', $asicVersion->id)->first() : $selModel['asic_versions'][0];
        $ads = $this->getAds()->where('asic_models.id', $selModel['id'])
            ->orderByRaw('ads.price = 0')->orderByRaw("ads.price * coin_rates.rate")->limit(9)->get();

        return view('calculator.index', [
            'models' => $models['all'],
            'popularModels' => $models['popular'],
            'rub' => $models['rub'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'ads' => $ads
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $models = Cache::get('optimized_calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models['all']->where('id', $asicModel->id)->first() : $models['all']->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['asic_versions'])->where('id', $asicVersion->id)->first() : $selModel['asic_versions'][0];

        return view('calculator.app', [
            'models' => $models['all'],
            'popularModels' => $models['popular'],
            'rub' => $models['rub'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
        ]);
    }

    public function calculatorWidjet(Request $request): ViewBlade
    {
        $models = Cache::get('optimized_calculator_models');

        if ($request->model) {
            $selModel = $asicModel = $models['all']->where('slug', $request->model)->first();
            if (!$selModel) $selModel = $models['all']->where('name', 'Antminer L9')->first();
        } else {
            $asicModel = null;
            $selModel = $models['all']->where('name', 'Antminer L9')->first();
        }

        if ($request->version) {
            $selVersion = $asicVersion = collect($selModel['asic_versions'])->where('hashrate', $request->version)->first();
            if (!$selVersion) $selVersion = $selModel['asic_versions'][0];
        } else {
            $asicVersion = null;
            $selVersion = $selModel['asic_versions'][0];
        }

        return view('calculator.widjet', [
            'models' => $models['all'],
            'popularModels' => $models['popular'],
            'rub' => $models['rub'],
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
        return response()->json(Cache::get('optimized_calculator_models'), 200);
    }
}
