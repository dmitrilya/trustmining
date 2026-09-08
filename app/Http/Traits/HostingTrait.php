<?php

namespace App\Http\Traits;

use App\Models\Ad\Hosting;
use Illuminate\Http\Request;

trait HostingTrait
{
    public function getHostings(?Request $request = null)
    {
        $hostings = Hosting::with(['user:id,name,slug,tf', 'user.phones:id,user_id'])->whereHas('user', function ($query) {
            $query->whereHas('tariff', function ($q) {
                $q->where('can_have_hosting', true);
            });
        });

        if ($request) {
            if ($request->peculiarities && count($request->peculiarities))
                $hostings = $hostings->whereJsonContains('peculiarities', $request->peculiarities);

            if ($request->sort) {
                $calculatedPriceSql = "(
                    COALESCE(
                        (SELECT MIN(CAST(jt.t AS DECIMAL(10,4)) / CAST(jt.u AS DECIMAL(10,4)))
                        FROM JSON_TABLE(hostings.tariffs, '$[*]' COLUMNS(t DECIMAL(10,4) PATH '$.t', u DECIMAL(10,4) PATH '$.u')) AS jt 
                        WHERE jt.u >= 97),
                        
                        (SELECT CAST(jt.t AS DECIMAL(10,4)) / CAST(jt.u AS DECIMAL(10,4))
                        FROM JSON_TABLE(hostings.tariffs, '$[*]' COLUMNS(t DECIMAL(10,4) PATH '$.t', u DECIMAL(10,4) PATH '$.u')) AS jt 
                        ORDER BY CAST(jt.u AS DECIMAL(10,4)) DESC LIMIT 1)
                    )
                )";

                switch ($request->sort) {
                    case 'price_low_to_high':
                        $hostings = $hostings->orderByRaw("{$calculatedPriceSql} ASC");
                        break;
                    case 'price_high_to_low':
                        $hostings = $hostings->orderByRaw("{$calculatedPriceSql} DESC");
                        break;
                }
            }
        }

        return $hostings;
    }

    public function getContractDeficiencies(Request $request, Hosting $hosting)
    {
        $user = $request->user();

        if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);

        return response()->json(['success' => true, 'deficiencies' => $hosting->contract_deficiencies]);
    }
}
