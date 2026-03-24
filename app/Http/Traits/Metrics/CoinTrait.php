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
        return response()->json(['rates' => $coin->coinRates()->whereRaw("TIME_FORMAT(created_at, '%H:%i') = ?", ['00:00'])->orderBy('created_at')->select(['rate', 'created_at'])->get()
            ->map(fn($rate) => ['date' => $rate->created_at->timestamp * 1000, 'value' => $rate->rate])], 200);
    }
}
