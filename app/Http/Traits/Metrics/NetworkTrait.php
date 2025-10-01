<?php

namespace App\Http\Traits\Metrics;

use Illuminate\Http\Request;

use App\Models\Coin;

trait NetworkTrait
{
    public function getHashrate(Request $request, Coin $coin)
    {
        return response()->json(['hashrates' => $coin->networkHashrates()->select(['hashrate', 'created_at'])->get()
            ->groupBy('created_at')->map(fn($day, $createdAt) => ['date' => $createdAt * 1000, 'value' => $day->avg('hashrate')])->values()], 200);
    }

    public function getDifficulty(Request $request, Coin $coin)
    {
        return response()->json(['difficulties' => $coin->networkDifficulties()->select(['difficulty', 'created_at'])->get()
            ->groupBy('created_at')->map(fn($day, $createdAt) => ['date' => $createdAt * 1000, 'value' => $day->avg('difficulty')])->values()], 200);
    }
}
