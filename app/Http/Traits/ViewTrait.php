<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait ViewTrait
{
    public function addView($request, $model, $adId = null)
    {
        $ip = $request->ip();
        $exceptAgents = ['bot', 'finder', 'lighthouse', 'googleother', 'crawler', 'inspectiontool'];
        $agent = strtolower($request->header('User-Agent'));

        foreach ($exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) return;
        }

        Log::channel('agents')->info("UserAgent={$agent} ip={$ip}");

        $auth = $request->user();
        if ($auth && (
            $model->user && $model->user->id == $auth->id ||
            $model->channel && $model->channel->user->id == $auth->id ||
            $auth->role->name != 'user'
        )) return;

        $now = now()->format('Y-m-d');
        $data = ['viewer' => $ip, 'created_at' => $now];
        if ($adId) $data['ad_id'] = $adId;

        $view = $model->views()->where($data)->first();

        if ($view) $view->increment('count');
        else {
            $data['count'] = 1;
            $view = $model->views()->create($data);
        }

        return $view;
    }
}
