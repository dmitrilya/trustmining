<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use App\Models\Coin;
use App\Models\Ad;

trait AdTrait
{
    public function getAds($request, $adCategory = null)
    {
        $ads = Ad::with([
            'adCategory:id,name,header',
            'user:id,name,url_name,tf',
            'user.phones:id,user_id',
            'office:id,city',
            'asicVersion:id,asic_model_id,hashrate,measurement',
            'asicVersion.asicModel:id,name',
            'coin:id,abbreviation'
        ]);

        if ($adCategory) $ads = $ads->where('ad_category_id', $adCategory->id);

        if ($request->model) {
            $ads = $ads->whereHas(
                'asicVersion.asicModel',
                function ($q) use ($request) {
                    $q->where('name', str_replace('_', ' ', $request->model));
                }
            );
        }

        if ($request->asic_version_id) {
            $ads = $ads->where('asic_version_id', $request->asic_version_id);
        }

        if ($request->algorithms && count($request->algorithms))
            $ads = $ads->whereHas('asicVersion.asicModel.algorithm', function ($q) use ($request) {
                $q->whereIn('name', $request->algorithms);
            });

        foreach ($request->collect()->except(['model', 'asic_version_id', 'algorithms']) as $key => $value) {
            $key = str_replace('_', ' ', $key);
            if (is_string($value)) $ads = $ads->whereJsonContains('props->' . $key, $value);
            elseif (count($value) === 1) {
                if (substr($value[0], 0, 1) == '>') {
                    if (substr($value[0], 1, 1) == '<') {
                        $value = explode('-', substr($value[0], 2));
                        $ads = $ads->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ? and CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", $value);
                    } else $ads = $ads->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ?", [substr($value[0], 1)]);
                } elseif (substr($value[0], 0, 1) == '<') $ads = $ads->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", [substr($value[0], 1)]);
                else $ads = $ads->whereJsonContains('props->' . $key, $value[0]);
            } else $ads = $ads->where(function ($q) use ($key, $value) {
                if (substr($value[0], 0, 1) == '>') {
                    if (substr($value[0], 1, 1) == '<') {
                        $values = explode('-', substr($value[0], 2));
                        $q->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ? and CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", $values);
                    } else $q->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ?", [substr($value[0], 1)]);
                } elseif (substr($value[0], 0, 1) == '<') $q->whereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", [substr($value[0], 1)]);
                else $q->whereJsonContains('props->' . $key, $value[0]);

                for ($i = 1; $i < count($value); $i++) {
                    if (substr($value[$i], 0, 1) == '>') {
                        if (substr($value[$i], 1, 1) == '<') {
                            $values = explode('-', substr($value[$i], 2));
                            $q->orWhereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ? and CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", $values);
                        } else $q->orWhereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) > ?", [substr($value[$i], 1)]);
                    } elseif (substr($value[$i], 0, 1) == '<') $q->orWhereRaw("CAST(JSON_EXTRACT(props, '$.\"$key\"') as UNSIGNED) <= ?", [substr($value[$i], 1)]);
                    else $q->orWhereJsonContains('props->' . $key, $value[$i]);
                }
            });
        }

        if ($request->display) {
            if ($request->display == 'active') $ads = $ads->where('moderation', false)->where('hidden', false);
            elseif ($request->display == 'moderation') $ads = $ads->whereHas('moderations', function ($q) {
                $q->where('moderation_status_id', 1);
            });
            elseif ($request->display == 'rejected') $ads = $ads->whereHas('moderations', function ($q) {
                $q->latest()->limit(1)->where('moderation_status_id', 3);
            });
            elseif ($request->display == 'hidden') $ads = $ads->where('hidden', true);
        }

        if ($request->sort && ($user = $request->user()) && ($user->tariff || $user->role_id != 2)) {
            $originalPrice = '`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)';

            switch ($request->sort) {
                case 'price_low_to_high':
                    $ads = $ads->orderByRaw($originalPrice);
                    break;
                case 'price_high_to_low':
                    $ads = $ads->orderByRaw($originalPrice . ' DESC');
                    break;
            }
        }

        return $ads;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Illuminate\Http\Request;
     * @param  \App\Models\Ad  $ad
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
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function track(Request $request, Ad $ad)
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
