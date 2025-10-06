<?php

namespace App\Http\Traits\Metrics;

use Illuminate\Http\Request;

use App\Models\Coin;

use Carbon\Carbon;

use DB;

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
            $avg = $dayDifficulties->avg('difficulty');

            $difficulty = $avg != $prevAvg ? ($avg > $prevAvg ? $dayDifficulties->max('difficulty') : $dayDifficulties->min('difficulty')) : $avg;
            array_push($difficulties, ['date' => Carbon::create($date)->timestamp * 1000, 'value' => $difficulty]);

            $prevAvg = $avg;
        }
        return response()->json(['difficulties' => $difficulties], 200);
    }
}
