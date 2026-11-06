<?php

namespace App\Http\Controllers\Wiki;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

use App\Models\Database\Coin;
use Illuminate\Http\Request;

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

    public function widjet(Request $request, Coin $coin): View
    {
        $locale = $request->input('lang', 'ru');

        if (!in_array($locale, array_keys(config('app.supported_locales')))) $locale = 'en';

        app()->setLocale($locale);

        $blocks = explode(',', $request->blocks);

        $rate = $coin->rate;
        $rate24hAgo = $coin->coinRates()->where('created_at', '<=', now()->subDay())->orderBy('created_at', 'desc')->value('rate');
        $rate_change = $rate24hAgo > 0 ? round((($rate - $rate24hAgo) / $rate24hAgo) * 100, 2) : 0;

        $measurement = $coin->algorithm?->measurement;
        if (in_array('hashrate', $blocks)) {
            $hashrate = $coin->networkHashrates()->latest()->first('hashrate')?->hashrate;
            if ($hashrate) {
                $measurements = ['', 'k', 'M', 'G', 'T', 'P', 'E', 'Z'];
                $am = in_array(strtolower($measurement), ['h', 'sol', 'g', 'c', 'k']) ? 0 :
                    array_search(substr($measurement, 0, 1), $measurements);
                $hashrate = $hashrate / pow(1000, $am);
            }
        }

        return view('wiki.coins.widjet', [
            'coin' => $coin,
            'rate' => $rate,
            'rate_change' => $rate_change,
            'hashrate' => $hashrate ?? null,
            'algorithm' => $coin->algorithm?->name,
            'measurement' => $measurement,
            'difficultyData' => in_array('difficulty', $blocks) || in_array('difficulty-prediction', $blocks) ? $coin->difficultyData() : null,
            'blocks' => $blocks,
            'theme' => $request->theme,
            'parentUrl' => $request->parent_url,
        ]);
    }
}
