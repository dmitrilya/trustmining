<?php

namespace App\Http\Traits;

use App\Models\Morph\View;

use Carbon\Carbon;

trait ViewTrait
{
    public function addView($request, $model, $adId = null)
    {
        //$exceptIPs = ['87.250.224.', '195.178.110.', '5.255.231.', '188.168.158.', '40.77.167.', '57.141.0.', '95.108.213.', '52.167.144.', '207.46.13.', '213.180.203.', '157.55.39.', '66.249.', '83.99.151.', '188.162.250.', '85.92.66.', '138.201.194.', '148.251.11.', '37.114.96.', '216.10.31.', '64.44.18.', '34.30.37.', '217.113.194.', '47.82.11.', '57.141.4.'];
        $ip = $request->ip();
        $exceptAgents = ['bingbot', 'Googlebot', 'YandexBot', 'SERankingBacklinksBot', 'Chrome-Lighthouse'];
        $agent = $request->header('User-Agent');

        foreach ($exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) return;
        }

        info($agent);

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
