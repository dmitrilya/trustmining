<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View;

use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Database\Coin;

class CalculatorController extends Controller
{
    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        if ($asicModel && $asicModel->exists) $this->addView(request(), $asicModel);

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();
        $ads = $this->getAds()->where('asic_models.id', $selModel->id)
            ->orderByRaw('ads.price = 0 ASC')->orderByRaw("ads.price * coins.rate ASC")->limit(9)->get();

        return view('calculator.index', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'ads' => $ads
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();

        return view('calculator.app', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
        ]);
    }

    public function calculatorWidjet(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): View
    {
        $models = Cache::get('calculator_models');

        $selModel = $asicModel && $asicModel->exists ? $models->where('id', $asicModel->id)->first() : $models->where('name', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? $selModel->asicVersions->where('id', $asicVersion->id)->first() : $selModel->asicVersions->first();

        return view('calculator.widjet', [
            'models' => $models,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'blocks' => $request->blocks,
            'theme' => $request->theme,
        ]);
    }

    public function calculatorModels()
    {
        return response()->json(Cache::get('calculator_models'), 200);
    }
}
