<?php

namespace App\Http\Traits;

use App\Models\Ad\Hosting;
use Illuminate\Http\Request;

trait HostingTrait
{
    public function getHostings($request)
    {
        $hostings = Hosting::with(['user:id,name,url_name,tf', 'user.phones:id,user_id']);

        if ($request->peculiarities && count($request->peculiarities))
            $hostings = $hostings->whereJsonContains('peculiarities', $request->peculiarities);

        if ($request->sort && ($user = $request->user()) && $user->tariff)
            switch ($request->sort) {
                case 'price_low_to_high':
                    $hostings = $hostings->orderBy('price');
                    break;
                case 'price_high_to_low':
                    $hostings = $hostings->orderByDesc('price');
                    break;
            }
        else $hostings = $hostings->inRandomOrder();

        return $hostings;
    }

    public function getContractDeficiencies(Request $request, Hosting $hosting)
    {
        $user = $request->user();

        if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);
        
        return response()->json(['success' => true, 'deficiencies' => $hosting->contract_deficiencies]);
    }
}
