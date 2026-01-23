<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Database\Coin;
use App\Models\Ad\AdCategory;
use App\Models\Ad\Ad;

trait AdTrait
{
    public function getAds(Request $request, ?AdCategory $category = null)
    {
        $ads = Ad::query()
            ->with($this->relations())
            ->when($category, fn($q) => $q->whereBelongsTo($category))
            ->when($request->model, fn($q) => $this->filterModel($q, $request->model))
            ->when($request->asic_version_id, fn($q) => $q->where('asic_version_id', $request->asic_version_id))
            ->when($request->algorithms, fn($q) => $this->filterAlgorithms($q, $request->algorithms))
            ->tap(fn($q) => $this->applyPropsFilters($q, $request))
            ->tap(fn($q) => $this->applyDisplay($q, $request))
            ->tap(fn($q) => $this->applySort($q, $request));

        return $ads;
    }

    protected function relations(): array
    {
        return [
            'adCategory:id,name,header',
            'user:id,name,url_name,tf',
            'user.phones:id,user_id',
            'office:id,city',
            'asicVersion:id,asic_model_id,hashrate,measurement',
            'asicVersion.asicModel:id,name',
            'coin:id,abbreviation',
        ];
    }

    protected function filterModel($q, string $model): void
    {
        $q->whereHas(
            'asicVersion.asicModel',
            fn($q) =>
            $q->where('name', str_replace('_', ' ', $model))
        );
    }

    protected function filterAlgorithms($q, array $algorithms): void
    {
        $q->whereHas(
            'asicVersion.asicModel.algorithm',
            fn($q) => $q->whereIn('name', $algorithms)
        );
    }

    protected function applyPropsFilters($q, Request $request): void
    {
        $filters = collect($request->except([
            'model',
            'asic_version_id',
            'algorithms',
            'page',
            'sort',
            'display'
        ]));

        foreach ($filters as $key => $value) {
            $this->applyJsonFilter($q, str_replace('_', ' ', $key), $value);
        }
    }

    protected function applyJsonFilter($q, string $key, $value): void
    {
        $values = (array) $value;

        $q->where(function ($q) use ($key, $values) {
            foreach ($values as $v) {
                match (true) {
                    str_starts_with($v, '><') => $this->between($q, $key, $v),
                    str_starts_with($v, '>')  => $this->greater($q, $key, $v),
                    str_starts_with($v, '<')  => $this->less($q, $key, $v),
                    default                   => $q->orWhereJsonContains("props->$key", $v),
                };
            }
        });
    }

    protected function greater($q, string $key, string $v)
    {
        $q->orWhereRaw(
            "CAST(JSON_EXTRACT(props, '$.\"$key\"') AS UNSIGNED) > ?",
            [substr($v, 1)]
        );
    }

    protected function applyDisplay($q, Request $r): void
    {
        match ($r->display) {
            'active'     => $q->where('moderation', false)->where('hidden', false),
            'moderation' => $q->whereHas('moderations', fn($q) => $q->where('moderation_status_id', 1)),
            'rejected'   => $q->whereHas('moderations', fn($q) => $q->latest()->limit(1)->where('moderation_status_id', 3)),
            'hidden'     => $q->where('hidden', true),
            default      => null
        };
    }

    protected function applySort($q, Request $r): void
    {
        if (!$r->sort || !$user = $r->user()) return;

        if (!$user->tariff && $user->role_id == 2) return;

        $price = '`price` * (SELECT rate FROM coins WHERE coins.id = ads.coin_id LIMIT 1)';

        match ($r->sort) {
            'price_low_to_high' => $q->orderByRaw($price),
            'price_high_to_low' => $q->orderByRaw("$price DESC"),
            default => null
        };
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function toggleHidden(Request $request, Ad $ad)
    {
        $user = $request->user();

        if ($ad->hidden && ($user->tariff && $user->ads()->where('hidden', false)->count() >= $user->tariff->max_ads || !$user->tariff && $user->ads()->where('hidden', false)->count() >= 2))
            return response()->json(['success' => false, 'message' => __('Not available with current plan')]);

        $ad->hidden = !$ad->hidden;
        $ad->save();

        return response()->json(['success' => true]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\Ad\AdCategory  $adCategory;
     * @param  \App\Models\Ad\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request, AdCategory $adCategory, Ad $ad)
    {
        $user = $request->user();

        if (!$user || !$user->tariff) return response()->json(['success' => false, 'message' => __('This feature is only available with a subscription')]);

        if ($ad->trackingUsers()->where('users.id', $user->id)->exists()) {
            $ad->trackingUsers()->detach($user->id);
            $tracking = false;
            $message = 'You have unsubscribed from notifications.';
        } else {
            $ad->trackingUsers()->attach($user->id);
            $tracking = true;
            $message = 'You have successfully subscribed to price change notifications.';
        }

        return response()->json(['success' => true, 'tracking' => $tracking, 'message' => __($message)]);
    }
}
