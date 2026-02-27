<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Database\Coin;
use App\Models\Ad\AdCategory;
use App\Models\Ad\Ad;

trait AdTrait
{
    public function getAds(?Request $request = null, ?AdCategory $adCategory = null)
    {
        $authId = auth()->id() ?? 0;
        $adClass = addslashes(Ad::class);

        $ads = DB::table('ads')
            ->leftJoin('users', 'users.id', '=', 'ads.user_id')
            ->leftJoin('ad_categories', 'ad_categories.id', '=', 'ads.ad_category_id')
            ->leftJoin('offices', 'offices.id', '=', 'ads.office_id')
            ->leftJoin('asic_versions', 'asic_versions.id', '=', 'ads.asic_version_id')
            ->leftJoin('asic_models', 'asic_models.id', '=', 'asic_versions.asic_model_id')
            ->leftJoin('gpu_models', 'gpu_models.id', '=', 'ads.gpu_model_id')
            ->leftJoin('gpu_brands', 'gpu_brands.id', '=', 'gpu_models.gpu_brand_id')
            ->leftJoin('coins', 'coins.id', '=', 'ads.coin_id')

            ->select([
                'ads.id',
                'ads.price',
                'ads.with_vat',
                'ads.preview',
                'ads.ordering_id',
                'ads.props',
                'ads.hidden',
                'ads.moderation',
                'ads.created_at',

                'ad_categories.name as ad_category_name',
                'ad_categories.header as ad_category_header',

                'users.id as user_id',
                'users.name as user_name',
                'users.url_name as user_url_name',
                'users.tf as user_tf',

                'offices.id as office_id',
                'offices.city',

                'asic_versions.hashrate as asic_version_hashrate',
                'asic_versions.measurement as asic_version_measurement',
                'asic_models.name as asic_model_name',

                'gpu_models.name as gpu_model_name',
                'gpu_models.max_power as gpu_model_max_power',
                'gpu_brands.name as gpu_brand_name',
                'coins.abbreviation as coin',
                'coins.rate as coin_rate',

                DB::raw("EXISTS (SELECT 1 FROM phones WHERE phones.user_id = users.id) as user_has_phone"),
                DB::raw("(SELECT m2.moderation_status_id FROM moderations m2 WHERE m2.moderationable_id = ads.id AND m2.moderationable_type = '{$adClass}' ORDER BY m2.id DESC LIMIT 1) as last_moderation_status"),
                DB::raw("EXISTS (SELECT 1 FROM tracks t WHERE t.ad_id = ads.id AND t.user_id = {$authId}) as is_tracked"),
            ]);

        if ($adCategory) $ads->where('ads.ad_category_id', $adCategory->id);

        if ($request) {
            if ($request->model) $ads->where('asic_models.name', str_replace('_', ' ', $request->model));

            if ($request->asic_version_id) $ads->where('ads.asic_version_id', $request->asic_version_id);

            if ($request->gpu_model) $ads->where('gpu_models.name', str_replace('_', ' ', $request->gpu_model));

            if ($request->algorithms && count($request->algorithms))
                $ads->join('algorithms', 'algorithms.id', '=', 'asic_models.algorithm_id')->whereIn('algorithms.name', $request->algorithms);

            if ($request->brands && count($request->brands)) {
                $brands = array_map(function ($brand) {
                    return str_replace('_', ' ', $brand);
                }, $request->brands);
                $ads->join('asic_brands', 'asic_brands.id', '=', 'asic_models.asic_brand_id')
                    ->whereIn(DB::raw('LOWER(asic_brands.name)'), $brands);
            }

            if ($request->manufacturers && count($request->manufacturers)) {
                $manufacturers = array_map(function ($brand) {
                    return str_replace('_', ' ', $brand);
                }, $request->manufacturers);
                $ads->whereIn(DB::raw('LOWER(gpu_brands.name)'), $manufacturers);
            }

            if ($request->max_power) {
                $ads->where(function ($q) use ($request) {
                    foreach ($request->max_power as $index => $val) {
                        $method = ($index === 0) ? 'where' : 'orWhere';

                        if (str_starts_with($val, '><')) {
                            $range = explode('-', substr($val, 2));
                            $q->{$method . 'Raw'}("CAST(gpu_models.max_power AS UNSIGNED) BETWEEN ? AND ?", [(int)$range[0], (int)$range[1]]);
                        } elseif (str_starts_with($val, '>')) {
                            $q->{$method . 'Raw'}("CAST(gpu_models.max_power AS UNSIGNED) > ?", [(int)substr($val, 1)]);
                        }
                    }
                });
            }

            if ($request->vat && count($request->vat) == 1) {
                if ($request->vat[0] == 'with_vat') $ads->where('with_vat', true);
                elseif ($request->vat[0] == 'without_vat') $ads->where('with_vat', false);
            }

            $filters = $request->collect()->except(['manufacturers', 'max_power', 'brands', 'model', 'asic_version_id', 'gpu_model', 'algorithms', 'vat', 'page', 'sort', 'city', 'display']);

            foreach ($filters as $key => $values) {
                $key = str_replace('_', ' ', $key);
                $values = is_array($values) ? $values : [$values];

                $ads->where(function ($q) use ($key, $values) {
                    foreach ($values as $index => $val) {
                        $method = ($index === 0) ? 'where' : 'orWhere';

                        if (str_starts_with($val, '><')) {
                            $range = explode('-', substr($val, 2));
                            $q->{$method . 'Raw'}("CAST(ads.props->'$.\"$key\"' AS UNSIGNED) BETWEEN ? AND ?", [(int)$range[0], (int)$range[1]]);
                        } elseif (str_starts_with($val, '>')) {
                            $q->{$method . 'Raw'}("CAST(ads.props->'$.\"$key\"' AS UNSIGNED) > ?", [(int)substr($val, 1)]);
                        } elseif (str_starts_with($val, '<')) {
                            $q->{$method . 'Raw'}("CAST(ads.props->'$.\"$key\"' AS UNSIGNED) <= ?", [(int)substr($val, 1)]);
                        } else {
                            $q->{$method . "JsonContains"}("props->{$key}", $val);
                        }
                    }
                });
            }

            if ($request->city) $ads->orderByRaw("CASE WHEN offices.city = ? THEN 1 ELSE 0 END DESC", [$request->city]);

            if ($request->display) {
                switch ($request->display) {
                    case 'active':
                        $ads->where('ads.moderation', false)->where('ads.hidden', false);
                        break;

                    case 'moderation':
                        $ads->whereExists(function ($query) use ($adClass) {
                            $query->select(DB::raw(1))->from('moderations')->whereColumn('moderations.moderationable_id', 'ads.id')->where('moderations.moderationable_type', $adClass)->where('moderations.moderation_status_id', 1);
                        });
                        break;

                    case 'rejected':
                        $ads->where(function ($query) use ($adClass) {
                            $query->select('moderation_status_id')->from('moderations')->whereColumn('moderationable_id', 'ads.id')->where('moderationable_type', $adClass)->orderBy('id', 'desc')->limit(1);
                        }, 3);
                        break;

                    case 'hidden':
                        $ads->where('ads.hidden', true);
                        break;
                }
            }

            if ($request->sort) {
                $convertedPrice = 'ads.price * coins.rate';

                switch ($request->sort) {
                    case 'price_low_to_high':
                        $ads->orderByRaw('ads.price = 0 ASC')->orderByRaw("{$convertedPrice} ASC");
                        break;
                    case 'price_high_to_low':
                        $ads->orderByRaw('ads.price = 0 ASC')->orderByRaw("{$convertedPrice} DESC");
                        break;
                }
            }
        }

        return $ads;
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
