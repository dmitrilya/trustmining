<?php

namespace App\Http\Traits;

use App\Models\View;

use Carbon\Carbon;

trait ViewTrait
{
    public function addView($request, $model, $adId = null)
    {
        $auth = $request->user();

        if ($auth && ($model->user && $model->user->id == $auth->id || $auth->role->name != 'user')) return;

        $class = get_class($model);

        $data = [
            'viewable_id' => $model->id,
            'viewable_type' => $class,
            'viewer' => $request->ip(),
            'created_at' => Carbon::now()->format('Y-m-d')
        ];

        if ($adId) $data['ad_id'] = $adId;

        $view = View::firstOrCreate($data);

        $view->increment('count');

        return $view;
    }
}
