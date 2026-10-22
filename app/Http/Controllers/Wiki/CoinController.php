<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use App\Models\Database\Coin;

class CoinController extends Controller
{
    public function index(): View
    {
        $coins = Coin::withCount('views')->orderByDesc('views_count')->get();

        return view('wiki.coins.index', [
            'coins' => $coins,
            'data' => Cache::get('home_page_data'),
        ]);
    }

    public function show(Coin $coin): View
    {
        return view('wiki.coins.show', [
            'coin' => $coin,
            'data' => Cache::get('home_page_data'),
        ]);
    }
}
