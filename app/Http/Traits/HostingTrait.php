<?php

namespace App\Http\Traits;

use App\Models\Hosting;

trait HostingTrait
{
    public function getHostings($request)
    {
        $hostings = Hosting::with(['user', 'user.company', 'user.contacts.contactType']);

        if ($request->peculiarities && count($request->peculiarities))
            $hostings = $hostings->whereJsonContains('peculiarities', $request->peculiarities);

        /*if ($request->conditions && count($request->conditions) && count($request->conditions) === 1) {
            if (in_array('new', $request->conditions)) $ads = $ads->where('new', true);
            else $ads = $ads->where('new', false);
        }

        if ($request->availabilities && count($request->availabilities) && count($request->availabilities) === 1) {
            if (in_array('in_stock', $request->availabilities)) $ads = $ads->where('in_stock', true);
            else $ads = $ads->where('in_stock', false);
        }*/

        if ($request->sort && ($user = $request->user()) && $user->tariff)
            switch ($request->sort) {
                case 'price_low_to_high':
                    $hostings = $hostings->orderBy('price');
                    break;
                case 'price_high_to_low':
                    $hostings = $hostings->orderByDesc('price');
                    break;
            }

        return $hostings;
    }
}
