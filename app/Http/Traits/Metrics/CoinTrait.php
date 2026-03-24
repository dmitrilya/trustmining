<?php

namespace App\Http\Traits\Metrics;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Database\Coin;

use Carbon\Carbon;

trait CoinTrait
{
    public function getCoinRate(Request $request, Coin $coin)
    {
        return response()->json(['rates' => $coin->coinRates()->select(['rate', DB::raw('Date(created_at) as date')])->get()
            ->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'value' => $day->avg('rate')])->values()], 200);
    }
}
