<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Metrics\NetworkTrait;

use App\Models\Coin;

use Carbon\Carbon;

class MetricsController extends Controller
{
    use NetworkTrait;

    public function index(Request $request)
    {
        return redirect()->route('metrics.network.difficulty', ['coin' => 'bitcoin']);
    }

    public function hashrate(Request $request, Coin $coin)
    {
        $latestHashrate = $coin->networkHashrates()->latest()->first('hashrate');

        if (!$latestHashrate) return back();

        return view('metrics.network.hashrate.index', [
            'coin' => $coin,
            'hashrate' => $latestHashrate->hashrate
        ]);
    }

    public function difficulty(Request $request, Coin $coin)
    {
        $difficulties = $coin->networkDifficulties()->where('created_at', '>', Carbon::now()->subDays(31))
            ->latest()->select(['difficulty', 'need_blocks', 'created_at'])->get();

        if (!$difficulties->count()) return back();

        $prediction = null;

        if ($coin->predictionable) {
            $recalcuateDates = [];

            foreach ($difficulties as $i => $difficulty) {
                if (!isset($difficulties[$i + 1])) return back();

                if ($difficulty->need_blocks > $difficulties[$i + 1]->need_blocks) {
                    array_push($recalcuateDates, $difficulty->created_at);
                    if (count($recalcuateDates) == 2) break;
                }
            }

            $prediction = round(($coin->networkHashrates()->where('created_at', '>', Carbon::createFromTimestamp($recalcuateDates[0]))->avg('hashrate') / $coin->networkHashrates()->whereBetween('created_at', [Carbon::createFromTimestamp($recalcuateDates[1]), Carbon::createFromTimestamp($recalcuateDates[0])])->avg('hashrate') - 1) * 100, 2);
        }

        return view('metrics.network.difficulty.index', [
            'coin' => $coin,
            'difficulty' => $difficulties->first()->difficulty,
            'prediction' => $prediction
        ]);
    }
}
