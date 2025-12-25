<?php

namespace App\Http\Traits;

use App\Models\Morph\View;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

trait ViewTrait
{
    public function addView($request, $model, $adId = null)
    {
        $ip = $request->ip();
        $exceptAgents = ['bot', 'GeedoShopProductFinder', 'Chrome-Lighthouse', 'googleother'];
        $agent = strtolower($request->header('User-Agent'));

        foreach ($exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) return;
        }

        Log::channel('agents')->info("UserAgent={$agent} ip={$ip}");

        $auth = $request->user();

        if ($auth && ($model->user && $model->user->id == $auth->id || $auth->role->name != 'user')) return;

        $class = get_class($model);

        $data = [
            'viewable_id' => $model->id,
            'viewable_type' => $class,
            'viewer' => $ip,
            'created_at' => Carbon::now()->format('Y-m-d')
        ];

        if ($adId) $data['ad_id'] = $adId;

        $view = View::firstOrCreate($data);

        $view->increment('count');

        return $view;
    }
}
