<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Log;

trait ViewTrait
{
    public function addView($request, $model, $adId = null)
    {
        if (is_bot_request()) return;

        $ip = $request->ip();
        $agent = strtolower($request->header('User-Agent'));

        Log::channel('agents')->info("UserAgent={$agent} ip={$ip}");

        $auth = $request->user();
        if ($auth) {
            if ($auth->role->name != 'user') return;

            $isOwner = ($model instanceof \App\Models\User\User)
                ? $model->id === $auth->id
                : ($model->user && $model->user->id === $auth->id);

            if ($isOwner) return;
        }

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
