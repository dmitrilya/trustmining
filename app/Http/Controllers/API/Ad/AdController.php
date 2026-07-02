<?php

namespace App\Http\Controllers\API\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Traits\AdTrait;

use App\Models\Database\Coin;
use App\Models\Ad\Ad;
use App\Models\Ad\AdCategory;

class AdController extends Controller
{
    use AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $ads = $this->getAds($request, AdCategory::where('name', 'miners')->first())->where('users.id', $request->user()->id)
            ->get()->map(function ($ad) {
                $ad->props = json_decode($ad->props, true);
                $props = [
                    'condition' => $ad->props['Condition'] == 'Used' ? 'used' : 'new',
                    'availability' => $ad->props['Availability'] == 'Preorder' ? 'preorder' : 'in_stock',
                ];

                if ($ad->props['Condition'] == 'Used') $props['warranty'] = $ad->props['Warranty (months)'];
                if ($ad->props['Availability'] == 'Preorder') $props['waiting'] = $ad->props['Waiting (days)'];

                return [
                    'id' => $ad->id,
                    'name' => $ad->asic_brand_name . ' ' . $ad->asic_model_name . ' ' . (float) $ad->asic_version_hashrate . $ad->asic_version_measurement,
                    'office' => $ad->city,
                    'props' => $props,
                    'price' => $ad->price,
                    'coin' => strtolower($ad->coin),
                    'with_vat' => $ad->with_vat,
                    'hidden' => $ad->hidden,
                ];
            });

        return response()->json([
            'ads' => $ads
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ads) return response()->json([
            'success' => false,
            'message' => 'Array ads not found in request bodyfix'
        ], 200);

        $user = $request->user()->load(['role:id,name', 'tariff:id,max_ads']);
        $activeAdsCount = $user->activeAds()->count();
        $maxAds = $user->tariff?->max_ads ?? config('settings.ads.max_count_without_tariff');

        $coins = array_change_key_case(Coin::whereIn('abbreviation', ['usdt', 'rub', 'cny'])->pluck('id', 'abbreviation')->all(), CASE_LOWER);
        $errors = [];

        $changings = collect($request->ads);
        $adsToChange = Ad::select(['id', 'hidden', 'props', 'price', 'coin_id', 'with_vat', 'user_id'])
            ->where('moderation', false)->whereIn('id', $changings->pluck('id'))->get();

        foreach (
            $changings->sortByDesc(function ($adChanges) {
                return array_key_exists('hidden', $adChanges) && $adChanges['hidden'];
            })->values()->all() as $adChanges
        ) {
            $ad = $adsToChange->where('id', $adChanges['id'])->first();

            if (!$ad) {
                array_push($errors, [
                    'id' => $adChanges['id'],
                    'error' => [
                        'field' => 'id',
                        'message' => "Ad with id {$adChanges['id']} does not exists or is under moderation."
                    ]
                ]);

                continue;
            }

            if (!($user->role->name == 'admin' || $ad->user_id == $user->id)) {
                array_push($errors, [
                    'id' => $adChanges['id'],
                    'error' => [
                        'field' => 'forbidden',
                        'message' => "You do not have permission to edit this ad."
                    ]
                ]);

                continue;
            }

            if (array_key_exists('price', $adChanges) && !is_int($adChanges['price'])) {
                array_push($errors, [
                    'id' => $adChanges['id'],
                    'error' => [
                        'field' => 'price',
                        'message' => 'Valid type of field "price" is int.'
                    ]
                ]);

                continue;
            }

            if (array_key_exists('with_vat', $adChanges) && !(is_bool($adChanges['with_vat']) || $adChanges['with_vat'] === 1 || $adChanges['with_vat'] === 0)) {
                array_push($errors, [
                    'id' => $adChanges['id'],
                    'error' => [
                        'field' => 'with_vat',
                        'message' => 'Valid type of field "with_vat" is boolean.'
                    ]
                ]);

                continue;
            }

            if (array_key_exists('hidden', $adChanges) && !(is_bool($adChanges['hidden']) || $adChanges['hidden'] === 1 || $adChanges['hidden'] === 0)) {
                array_push($errors, [
                    'id' => $adChanges['id'],
                    'error' => [
                        'field' => 'hidden',
                        'message' => 'Valid type of field "hidden" is boolean.'
                    ]
                ]);

                continue;
            }

            $changes = collect($adChanges)->only(['price', 'with_vat', 'hidden']);

            if (array_key_exists('coin', $adChanges)) {
                if (!array_key_exists($adChanges['coin'], $coins)) {
                    array_push($errors, [
                        'id' => $adChanges['id'],
                        'error' => [
                            'field' => 'coin',
                            'message' => "Coin {$adChanges['coin']} does not exists."
                        ]
                    ]);

                    continue;
                }

                $changes['coin_id'] = $coins[$adChanges['coin']];
            }

            if (array_key_exists('hidden', $adChanges)) {
                if (!$adChanges['hidden']) {
                    if ($ad->hidden) {
                        if ($activeAdsCount >= $maxAds) {
                            array_push($errors, [
                                'id' => $adChanges['id'],
                                'error' => [
                                    'field' => 'hidden',
                                    'message' => 'The maximum number of active ads has been exceeded.'
                                ]
                            ]);

                            continue;
                        }

                        $activeAdsCount++;
                    }
                } else $activeAdsCount--;
            }

            if (array_key_exists('props', $adChanges)) {
                $props = $ad->props;

                if (array_key_exists('warranty', $adChanges['props'])) {
                    if ($props['Condition'] != 'Used') {
                        array_push($errors, [
                            'id' => $adChanges['id'],
                            'error' => [
                                'field' => 'props.warranty',
                                'message' => 'The "warranty" property is only valid for "condition == used".'
                            ]
                        ]);

                        continue;
                    }

                    if (!is_int($adChanges['props']['warranty']) || $adChanges['props']['warranty'] < 0 || $adChanges['props']['warranty'] > 12) {
                        array_push($errors, [
                            'id' => $adChanges['id'],
                            'error' => [
                                'field' => 'props.warranty',
                                'message' => 'Valid type of field "warranty" is int. Min is 0, max is 12.'
                            ]
                        ]);

                        continue;
                    }

                    $props['Warranty (months)'] = $adChanges['props']['warranty'];
                }

                if (array_key_exists('waiting', $adChanges['props'])) {
                    if ($props['Availability'] != 'Preorder') {
                        array_push($errors, [
                            'id' => $adChanges['id'],
                            'error' => [
                                'field' => 'props.waiting',
                                'message' => 'The "waiting" property is only valid for "availability == preorder".'
                            ]
                        ]);

                        continue;
                    }

                    if (!is_int($adChanges['props']['waiting']) || $adChanges['props']['waiting'] < 1 || $adChanges['props']['waiting'] > 120) {
                        array_push($errors, [
                            'id' => $adChanges['id'],
                            'error' => [
                                'field' => 'props.waiting',
                                'message' => 'Valid type of field "waiting" is int. Min is 1, max is 120.'
                            ]
                        ]);

                        continue;
                    }

                    $props['Waiting (days)'] = $adChanges['props']['waiting'];
                }

                $changes['props'] = json_encode($props);
            }

            $ad->moderations()->create([
                'data' => $changes,
                'moderation_status_id' => 2,
                'user_id' => 10000000
            ]);

            $ad->update($changes->all());

            if (isset($changes['price']) && $changes['price'] != $ad->price || isset($changes['coin_id']) && $changes['coin_id'] != $ad->coin_id || isset($changes['with_vat']) && $changes['with_vat'] != $ad->with_vat)
                $this->notify(
                    'Price change',
                    $ad->trackingUsers()->select(['users.id', 'users.tg_id'])->get()->merge($ad->asicVersion->asicModel->trackingUsers()->select(['users.id', 'users.tg_id'])->get()),
                    'ad',
                    $ad
                );
        }

        return response()->json([
            'success' => true,
            'errors' => $errors
        ], 200);
    }
}
