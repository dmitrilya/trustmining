<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewBlade;

use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Database\Coin;

class CalculatorController extends Controller
{
    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $data = Cache::get('optimized_calculator_data');

        if ($asicModel && $asicModel->exists) $this->addView(request(), $asicModel);

        $selModel = $asicModel && $asicModel->exists ? $data['m']->where('i', $asicModel->id)->first() : $data['m']->where('n', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['v'])->where('i', $asicVersion->id)->first() : $selModel['v'][0];
        $ads = Cache::remember(
            'asic_model_ads_' . $selModel['i'],
            now()->endOfDay(),
            fn() => $this->getAds()->where('asic_models.id', $selModel['i'])
                ->orderByRaw('ads.price = 0')->orderByRaw("ads.price * coin_rates.rate")->limit(9)->get()
        );

        return view('calculator.index', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'coins' => collect($data['a'][$selVersion['a']]['c'])->pluck('n')->implode(', '),
            'fee' => $data['a'][$selVersion['a']]['c'][$selVersion['ps'][0]['c'][0]]['f'],
            'ads' => $ads,
            'difficultyData' => Cache::get('calculator_difficulty_data')
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $data = Cache::get('optimized_calculator_data');

        $selModel = $asicModel && $asicModel->exists ? $data['m']->where('i', $asicModel->id)->first() : $data['m']->where('n', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['v'])->where('i', $asicVersion->id)->first() : $selModel['v'][0];

        return view('calculator.app', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'fee' => $data['a'][$selVersion['a']]['c'][$selVersion['ps'][0]['c'][0]]['f'],
        ]);
    }

    public function calculatorWidjet(Request $request): ViewBlade
    {
        $data = Cache::get('optimized_calculator_data');

        if ($request->model) {
            $selModel = $asicModel = $data['m']->where('s', $request->model)->first();
            if (!$selModel) $selModel = $data['m']->where('n', 'Antminer L9')->first();
        } else {
            $asicModel = null;
            $selModel = $data['m']->where('n', 'Antminer L9')->first();
        }

        if ($request->version) {
            $selVersion = $asicVersion = collect($selModel['v'])->where('h', $request->version)->first();
            if (!$selVersion) $selVersion = $selModel['v'][0];
        } else {
            $asicVersion = null;
            $selVersion = $selModel['v'][0];
        }

        return view('calculator.widjet', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'fee' => $data['a'][$selVersion['a']]['c'][$selVersion['ps'][0]['c'][0]]['f'],
            'blocks' => explode(',', $request->blocks),
            'theme' => $request->theme,
        ]);
    }

    public function calculatorData()
    {
        return response()->json(Cache::get('optimized_calculator_data'), 200);
    }
}
