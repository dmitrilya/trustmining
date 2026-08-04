<?php

namespace App\Http\Controllers;

use App\Enums\FirmwareModeStrainLevel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\View\View as ViewBlade;

use App\Http\Traits\ViewTrait;
use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Ad\Ad;
use App\Models\Ad\AdCategory;

class CalculatorController extends Controller
{
    use ViewTrait;

    public function calculator(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $data = Cache::get('optimized_calculator_data');

        $selModel = $asicModel && $asicModel->exists ? $data['m']->where('i', $asicModel->id)->first() : $data['m']->where('n', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['v'])->where('i', $asicVersion->id)->first() : $selModel['v'][0];
        $ads = Cache::remember(
            'asic_model_ads_' . $selModel['i'],
            now()->endOfDay(),
            fn() => $this->getAds(AdCategory::where('name', 'miners')->value('id'))->where('ads.moderation', false)->where('ads.hidden', false)
                ->where('asic_models.id', $selModel['i'])->orderByRaw('ads.price = 0')->orderByRaw("ads.price * coin_rates.rate")->limit(9)->get()
        );

        $firmwares = collect();
        $adFirmwares = Ad::where('ad_category_id', 7)->where('moderation', false)->where('hidden', false)
            ->select(['user_id', 'asic_version_id', 'props'])->with(['user:id,name', 'asicVersion:id,measurement'])->get();

        foreach ($adFirmwares as $firmware) {
            foreach ($firmware->props['Modes'] as $mode) {
                $firmwareModeStrainLevel = FirmwareModeStrainLevel::from($mode['s']);

                $firmwares->push([
                    'c' => $firmware->user->name,
                    'h' => (float) $mode['h'],
                    'e' => (float) $mode['e'],
                    'v' => $firmware->asicVersion->id,
                    'm' => $firmware->asicVersion->measurement,
                    's' => $firmwareModeStrainLevel->bg() . ' ' . $firmwareModeStrainLevel->text()
                ]);
            }
        }

        return view('calculator.index', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'coins' => collect($data['a'][$selVersion['a']]['p'])->pluck('c')->flatten(1)->pluck('n')->implode(', '),
            'fee' => count($data['a'][$selVersion['a']]['p']) ? $data['a'][$selVersion['a']]['p'][0]['c'][0]['f'] : 0,
            'firmwares' => $firmwares,
            'ads' => $ads,
            'difficultyData' => Cache::get('calculator_difficulty_data')
        ]);
    }

    public function calculatorApp(Request $request, ?AsicModel $asicModel = null, ?AsicVersion $asicVersion = null): ViewBlade
    {
        $data = Cache::get('optimized_calculator_data');

        $selModel = $asicModel && $asicModel->exists ? $data['m']->where('i', $asicModel->id)->first() : $data['m']->where('n', 'Antminer L9')->first();
        $selVersion = $asicVersion && $asicVersion->exists ? collect($selModel['v'])->where('i', $asicVersion->id)->first() : $selModel['v'][0];

        $firmwares = collect();
        $adFirmwares = Ad::where('ad_category_id', 7)->where('moderation', false)->where('hidden', false)
            ->select(['user_id', 'asic_version_id', 'props'])->with(['user:id,name', 'asicVersion:id,measurement'])->get();

        foreach ($adFirmwares as $firmware) {
            foreach ($firmware->props['Modes'] as $mode) {
                $firmwareModeStrainLevel = FirmwareModeStrainLevel::from($mode['s']);

                $firmwares->push([
                    'c' => $firmware->user->name,
                    'h' => (float) $mode['h'],
                    'e' => (float) $mode['e'],
                    'v' => $firmware->asicVersion->id,
                    'm' => $firmware->asicVersion->measurement,
                    's' => $firmwareModeStrainLevel->bg() . ' ' . $firmwareModeStrainLevel->text()
                ]);
            }
        }

        return view('calculator.app', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'fee' => count($data['a'][$selVersion['a']]['p']) ? $data['a'][$selVersion['a']]['p'][0]['c'][0]['f'] : 0,
            'firmwares' => $firmwares,
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

        $firmwares = collect();
        $adFirmwares = Ad::where('ad_category_id', 7)->where('moderation', false)->where('hidden', false)
            ->select(['user_id', 'asic_version_id', 'props'])->with(['user:id,name', 'asicVersion:id,measurement'])->get();

        foreach ($adFirmwares as $firmware) {
            foreach ($firmware->props['Modes'] as $mode) {
                $firmwareModeStrainLevel = FirmwareModeStrainLevel::from($mode['s']);

                $firmwares->push([
                    'c' => $firmware->user->name,
                    'h' => (float) $mode['h'],
                    'e' => (float) $mode['e'],
                    'v' => $firmware->asicVersion->id,
                    'm' => $firmware->asicVersion->measurement,
                    's' => $firmwareModeStrainLevel->bg() . ' ' . $firmwareModeStrainLevel->text()
                ]);
            }
        }

        return view('calculator.widjet', [
            'rub' => $data['r'],
            'rModel' => $asicModel,
            'rVersion' => $asicVersion,
            'selModel' => $selModel,
            'selVersion' => $selVersion,
            'algorithms' => collect([$data['a'][$selVersion['a']]])->keyBy('i'),
            'algorithm' => $data['a'][$selVersion['a']]['n'],
            'fee' => count($data['a'][$selVersion['a']]['p']) ? $data['a'][$selVersion['a']]['p'][0]['c'][0]['f'] : 0,
            'firmwares' => $firmwares,
            'blocks' => explode(',', $request->blocks),
            'theme' => $request->theme,
        ]);
    }

    public function calculatorData()
    {
        return response()->json(Cache::get('optimized_calculator_data'), 200);
    }
}
