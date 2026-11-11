<?php

namespace App\Http\Controllers\Rating;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

use App\Models\User\User;
use App\Models\Ad\Hosting;

class HostingRatingController extends Controller
{
    public function show(string $type): View
    {
        $hostings = Hosting::with(['user:id,name,slug,tf'])->get()
            ->map(fn($h) => tap($h, fn($h) => $h->price = collect($h->tariffs)->min(fn($t) => $t['t'] / $t['u'])))
            ->groupBy('user_id')->map(fn($userHostings) => $userHostings->sortBy('price')->first())->values();

        if ($type === 'reliable') $hostings = $hostings->sortByDesc(fn($h) => $h->user->tf ?? 0);
        elseif ($type === 'cheapest') $hostings = $hostings->sortBy('price');
        else {
            $uniquePrices = $hostings->pluck('price')->unique()->sortDesc()->values();
            $uniqueTfs = $hostings->map(fn($h) => $h->user->tf ?? 0)->unique()->sort()->values();

            $priceDenominator = max(1, $uniquePrices->count() - 1);
            $tfDenominator = max(1, $uniqueTfs->count() - 1);

            $hostings = $hostings->map(function ($hosting) use ($uniquePrices, $uniqueTfs, $priceDenominator, $tfDenominator) {
                $priceRank = $uniquePrices->search($hosting->price);
                $pricePoints = $uniquePrices->count() <= 1 ? 10 : 1 + ($priceRank / $priceDenominator) * 9;

                $tfRank = $uniqueTfs->search($hosting->user->tf);
                $tfPoints = $uniqueTfs->count() <= 1 ? 15 : 1.5 + ($tfRank / $tfDenominator) * 13.5;

                $hosting->balanced_score = $pricePoints + $tfPoints;

                return $hosting;
            })->sort(function ($a, $b) {
                if ($a->balanced_score !== $b->balanced_score) return $b->balanced_score <=> $a->balanced_score;

                return $b->user->tf <=> $a->user->tf;
            });
        }

        return view('rating.hostings.show', [
            'type' => $type,
            'hostings' => $hostings->take(5)->values(),
        ]);
    }
}
