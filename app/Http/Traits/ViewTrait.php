<?php

namespace App\Http\Traits;

use App\Models\View;

trait ViewTrait
{
    public function addView($request, $model)
    {
        $auth = $request->user();

        if ($auth && ($model->user && $model->user->id == $auth->id || $auth->role->name != 'user')) return;

        $class = get_class($model);

        $view = View::where([
            ['viewable_id', $model->id],
            ['viewable_type', $class],
            ['viewer', $request->ip()]
        ])->first();

        if (!$view) return View::create([
            'viewable_id' => $model->id,
            'viewable_type' => $class,
            'viewer' => $request->ip()
        ]);

        $view->increment('count');

        return $view;
    }
}
