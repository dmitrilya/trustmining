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
        $hostings = Hosting::with(['user:id,name,slug,tf'])->get();

        if ($type == 'reliable') $hostings = $hostings->sortByDesc(fn($h) => $h->user->tf);
        else {
            $hostings = $hostings->map(function ($hosting) {
                $hosting->price = collect($hosting->tariffs)->sortByDesc('u')->first()['t'];
                return $hosting;
            });

            if ($type == 'cheapest') $hostings = $hostings->sortBy('price');
            else {
                $sortedByPrice = $hostings->sortByDesc('price')->values();
                $totalCount = $sortedByPrice->count();

                $sortedByTf = $hostings->sortBy(fn($h) => $h->user->tf ?? 0)->values();

                $hostings = $hostings->map(function ($hosting) use ($sortedByPrice, $sortedByTf, $totalCount) {
                    if ($totalCount <= 1) {
                        $hosting->balanced_score = 10;
                        return $hosting;
                    }

                    $priceIndex = $sortedByPrice->search(fn($item) => $item->id === $hosting->id);
                    $pricePoints = 1 + ($priceIndex / ($totalCount - 1)) * 9;

                    $tfIndex = $sortedByTf->search(fn($item) => $item->id === $hosting->id);
                    $tfPoints = 1.5 + ($tfIndex / ($totalCount - 1)) * 13.5;

                    $hosting->balanced_score = $pricePoints + $tfPoints;

                    return $hosting;
                })->sortByDesc('balanced_score');
            }
        }

        return view('rating.hostings.show', ['type' => $type, 'hostings' => $hostings->take(5)]);
    }
}
