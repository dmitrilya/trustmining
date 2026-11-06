<?php

namespace App\Http\Traits\Metrics;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Database\Coin;

trait CoinTrait
{
    public function getCoinRate(Request $request, Coin $coin)
    {
        $startOfYesterday = now()->subDay()->startOfDay()->toDateTimeString();
        $startOfToday = now()->startOfDay()->toDateTimeString();

        $rates = $coin->coinRates()
            ->where(function ($query) use ($startOfYesterday) {
                $query->where('created_at', '>=', $startOfYesterday)
                    ->orWhereRaw("TIME_FORMAT(created_at, '%H:%i') = '00:00'");
            })
            ->groupBy(DB::raw("DATE(created_at)"))
            ->select([
                DB::raw("CASE 
                    WHEN MAX(created_at) >= '{$startOfToday}' THEN MAX(rate)
                    WHEN MAX(created_at) >= '{$startOfYesterday}' THEN AVG(rate)
                    ELSE MAX(rate)
                END as rate"),
                DB::raw("DATE_FORMAT(MIN(created_at), '%Y-%m-%d 00:00:00') as created_at")
            ])
            ->orderBy(DB::raw("MIN(created_at)"), 'asc')
            ->get();

        $formattedRates = $rates->map(fn($rate) => [
            'date'  => (is_string($rate->created_at) ? now()->parse($rate->created_at) : $rate->created_at)->timestamp * 1000,
            'value' => round((float) $rate->rate, 4)
        ]);

        return response()->json(['rates' => $formattedRates], 200);
    }
}
