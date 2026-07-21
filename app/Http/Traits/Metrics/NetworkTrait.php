<?php

namespace App\Http\Traits\Metrics;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Metrics\NetworkDifficulty;
use App\Models\Database\Coin;
use Carbon\Carbon;

trait NetworkTrait
{
    public function getHashrate(Request $request, Coin $coin)
    {
        return response()->json(['hashrates' => $coin->networkHashrates()->select(['hashrate', DB::raw('Date(created_at) as date')])->get()
            ->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'value' => $day->avg('hashrate')])->values()], 200);
    }

    public function getDifficulty(Request $request, Coin $coin)
    {
        $groupedDifficulties = $coin->networkDifficulties()->select(['difficulty', DB::raw('Date(created_at) as date')])
            ->get()->groupBy('date');
        $difficulties = [];
        $prevAvg = $groupedDifficulties->first()->avg('difficulty');

        foreach ($groupedDifficulties->slice(1) as $date => $dayDifficulties) {
            $avg = round($dayDifficulties->avg('difficulty'), 4);

            $difficulty = $avg != $prevAvg ? ($avg > $prevAvg ? $dayDifficulties->max('difficulty') : $dayDifficulties->min('difficulty')) : $avg;
            array_push($difficulties, ['date' => Carbon::create($date)->timestamp * 1000, 'value' => $difficulty]);

            $prevAvg = $avg;
        }
        return response()->json(['difficulties' => $difficulties], 200);
    }

    public function needBlocksTime(NetworkDifficulty $ld, float $blockTime): string
    {
        $time = $blockTime * $ld->need_blocks;
        $days = intdiv($time, 60 * 60 * 24);
        $time %= (60 * 60 * 24);
        $hours = intdiv($time, 60 * 60);
        $time %= (60 * 60);
        $minutes = intdiv($time, 60);
        $needBlocksTime = '~';
        if ($days > 0) $needBlocksTime .= $days . ' ' . trans_choice('time.days', $days) . ' ';
        if ($hours > 0) $needBlocksTime .= $hours . ' ' . trans_choice('time.hours', $hours) . ' ';
        if ($minutes > 0) $needBlocksTime .= $minutes . ' ' . trans_choice('time.minutes', $minutes);

        return $needBlocksTime;
    }
}
