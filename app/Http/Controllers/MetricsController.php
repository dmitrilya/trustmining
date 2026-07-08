<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Traits\Metrics\NetworkTrait;
use App\Http\Traits\Metrics\CoinTrait;
use App\Http\Traits\AdTrait;

use App\Models\Database\Coin;
use App\Models\Morph\View;
use App\Models\User\NotificationType;
use Carbon\Carbon;

class MetricsController extends Controller
{
    use NetworkTrait, CoinTrait, AdTrait;

    public function index(Request $request)
    {
        return redirect()->route('metrics.coin.rate', ['coin' => 'bitcoin']);
    }

    public function hashrate(Request $request, Coin $coin)
    {
        $latestHashrate = $coin->networkHashrates()->latest()->first('hashrate');

        if (!$latestHashrate) return back();

        $ads = Cache::remember(
            'algorithm_ads_' . $coin->algorithm->slug,
            now()->endOfDay(),
            fn() => $this->getAds()->whereIn('asic_models.id', View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(30)->pluck('viewable_id'))
                ->join('algorithms', 'algorithms.id', '=', 'asic_models.algorithm_id')->where('algorithms.slug', $coin->algorithm->slug)
                ->orderByDesc('ads.ordering_id')->limit(14)->get()
        );

        return view('metrics.network.hashrate.index', [
            'coin' => $coin,
            'hashrate' => $latestHashrate->hashrate,
            'ads' => $ads
        ]);
    }

    public function coinRate(Request $request, Coin $coin)
    {
        $latestRate = $coin->rate;

        $ads = Cache::remember(
            'algorithm_ads_' . $coin->algorithm->slug,
            now()->endOfDay(),
            fn() => $this->getAds()->whereIn('asic_models.id', View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(30)->pluck('viewable_id'))
                ->join('algorithms', 'algorithms.id', '=', 'asic_models.algorithm_id')->where('algorithms.slug', $coin->algorithm->slug)
                ->orderByDesc('ads.ordering_id')->limit(14)->get()
        );

        return view('metrics.coin.rate.index', [
            'coin' => $coin,
            'rate' => $latestRate,
            'ads' => $ads
        ]);
    }

    public function difficulty(Request $request, Coin $coin)
    {
        $data = $this->difficultyData($coin);

        if (!$data) return back();

        $ads = Cache::remember(
            'algorithm_ads_' . $coin->algorithm->slug,
            now()->endOfDay(),
            fn() => $this->getAds()->whereIn('asic_models.id', View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(30)->pluck('viewable_id'))
                ->join('algorithms', 'algorithms.id', '=', 'asic_models.algorithm_id')->where('algorithms.slug', $coin->algorithm->slug)
                ->orderByDesc('ads.ordering_id')->limit(14)->get()
        );

        return view('metrics.network.difficulty.index', [
            'coin' => $coin,
            'difficulty' => $data['lastDifficulty'],
            'needBlocksTime' => $data['needBlocksTime'],
            'prediction' => $data['prediction'],
            'ads' => $ads
        ]);
    }

    public function difficultyWidjet(Request $request, Coin $coin)
    {
        $data = $this->difficultyData($coin);

        if (!$data) return back();

        return view('metrics.network.difficulty.widjet', [
            'coin' => $coin,
            'difficulty' => $data['lastDifficulty'],
            'needBlocksTime' => $data['needBlocksTime'],
            'prediction' => $data['prediction'],
            'blocks' => explode(',', $request->blocks),
            'theme' => $request->theme,
        ]);
    }

    public function difficultySubscribe(Request $request, Coin $coin)
    {
        $notificationTypeId = NotificationType::where('name', 'Difficulty changing')->value('id');
        $settings = $request->user()->settings;
        $notifications = $settings->notifications;
        $currentCoins = $notifications[$notificationTypeId]['c'];

        if (!in_array($coin->id, $currentCoins)) {
            $currentCoins[] = (int) $coin->id;
            $notifications[$notificationTypeId]['c'] = array_values($currentCoins);

            $settings->notifications = $notifications;
            $settings->save();
        }

        return response()->json([
            'success' => true,
            'message' => __('You have subscribed to difficulty') . ' ' . $coin->abbreviation
        ]);
    }

    public function difficultyUnsubscribe(Request $request, Coin $coin)
    {
        $notificationTypeId = NotificationType::where('name', 'Difficulty changing')->value('id');
        $settings = $request->user()->settings;

        $notifications = $settings->notifications;
        $currentCoins = $notifications[$notificationTypeId]['c'];

        if (($key = array_search($coin->id, $currentCoins)) !== false) {
            unset($currentCoins[$key]);
            $notifications[$notificationTypeId]['c'] = array_values($currentCoins);

            $settings->notifications = $notifications;
            $settings->save();
        }

        return response()->json([
            'success' => true,
            'message' => __('You have unsubscribed to difficulty') . ' ' . $coin->abbreviation
        ]);
    }
}
