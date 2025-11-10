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

        $lastDifficulty = $difficulties->first();
        $prediction = null;
        $needBlocksTime = null;

        if ($coin->predictionable) {
            $recalcuateDates = [];

            foreach ($difficulties as $i => $difficulty) {
                if (!isset($difficulties[$i + 1])) return back();

                if (!$needBlocksTime && $i == 6) {
                    $time = ($lastDifficulty->created_at - $difficulty->created_at) / ($difficulty->need_blocks - $lastDifficulty->need_blocks) * $lastDifficulty->need_blocks;
                    $days = intdiv($time, 60 * 60 * 24);
                    $time %= (60 * 60 * 24);
                    $hours = intdiv($time, 60 * 60);
                    $time %= (60 * 60);
                    $minutes = intdiv($time, 60);
                    $needBlocksTime = '~';
                    if ($days > 0) $needBlocksTime .= $days . ' ' . trans_choice('time.days', $days) . ' ';
                    if ($hours > 0) $needBlocksTime .= $hours . ' ' . trans_choice('time.hours', $hours) . ' ';
                    if ($minutes > 0) $needBlocksTime .= $minutes . ' ' . trans_choice('time.minutes', $minutes);
                }

                if ($difficulty->need_blocks > $difficulties[$i + 1]->need_blocks) {
                    if (!$needBlocksTime) {
                        if ($i == 0) $needBlocksTime = __('Time calculation');
                        else {
                            $time = ($lastDifficulty->created_at - $difficulty->created_at) / ($difficulty->need_blocks - $lastDifficulty->need_blocks) * $lastDifficulty->need_blocks;
                            $days = intdiv($time, 60 * 60 * 24);
                            $time %= (60 * 60 * 24);
                            $hours = intdiv($time, 60 * 60);
                            $time %= (60 * 60);
                            $minutes = intdiv($time, 60);
                            $needBlocksTime = '~';
                            if ($days > 0) $needBlocksTime .= $days . ' ' . trans_choice('time.days', $days) . ' ';
                            if ($hours > 0) $needBlocksTime .= $hours . ' ' . trans_choice('time.hours', $hours) . ' ';
                            if ($minutes > 0) $needBlocksTime .= $minutes . ' ' . trans_choice('time.minutes', $minutes);
                        }
                    }

                    array_push($recalcuateDates, $difficulty->created_at);
                    if (count($recalcuateDates) == 2) break;
                }
            }

            $prediction = round(($coin->networkHashrates()->where('created_at', '>', Carbon::createFromTimestamp($recalcuateDates[0]))->avg('hashrate') / $coin->networkHashrates()->whereBetween('created_at', [Carbon::createFromTimestamp($recalcuateDates[1]), Carbon::createFromTimestamp($recalcuateDates[0])])->avg('hashrate') - 1) * 100, 2);
        }

        return view('metrics.network.difficulty.index', [
            'coin' => $coin,
            'difficulty' => $lastDifficulty,
            'needBlocksTime' => $needBlocksTime,
            'prediction' => $prediction
        ]);
    }
}
