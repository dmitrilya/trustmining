<?php

namespace App\Http\Traits;

use App\Models\Ad;

trait AdTrait
{
    public function getAds($request = null)
    {
        $ads = Ad::with(['adCategory:name', 'user:id,name,url_name,tf', 'user.company:id', 'user.contacts.contactType', 'office:id,city', 'asicVersion:id,asic_model_id,hashrate', 'asicVersion.asicModel:id,name,algorithm_id,measurement', 'asicVersion.asicModel.algorithm:id,measurement']);

        if (isset($request)) {
            /*if ($request->brands && count($request->brands)) {
                $ads = $ads->whereHas(
                    'asicVersion.asicModel.asicBrand',
                    function ($q) use ($request) {
                        $q->whereIn('name', collect($request->brands)->map(function ($brand) {
                            return str_replace('_', ' ', $brand);
                        }));
                    }
                );

                if ($request->models && count($request->models))
                    $ads = $ads->whereHas(
                        'asicVersion.asicModel',
                        function ($q) use ($request) {
                            $q->whereIn('name', collect($request->models)->map(function ($model) {
                                return str_replace('_', ' ', $model);
                            }));
                        }
                    );
            }*/

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

            if ($request->conditions && count($request->conditions) === 1) {
                if (in_array('new', $request->conditions)) $ads = $ads->where('new', true);
                else $ads = $ads->where('new', false);
            }

            if ($request->availabilities && count($request->availabilities) === 1) {
                if (in_array('in_stock', $request->availabilities)) $ads = $ads->where('in_stock', true);
                else $ads = $ads->where('in_stock', false);
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

            if ($request->sort && ($user = $request->user()) && $user->tariff)
                switch ($request->sort) {
                    case 'price_low_to_high':
                        $ads = $ads->orderBy('price');
                        break;
                    case 'price_high_to_low':
                        $ads = $ads->orderByDesc('price');
                        break;
                }
        }

        return $ads;
    }
}
