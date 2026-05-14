<?php

namespace App\Http\Controllers\API\Ad;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Traits\NotificationTrait;
use App\Http\Traits\FileTrait;
use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;

use App\Models\Ad\AdCategory;

class AdController extends Controller
{
    use NotificationTrait, FileTrait, ViewTrait, AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $ads = $this->getAds($request, AdCategory::where('name', 'miners')->first())->where('user_id', $request->user()->id)
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
                    'name' => $ad->asic_brand_name . ' ' . $ad->asic_model_name . ' ' . $ad->asic_version_hashrate . $ad->asic_version_measurement,
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
}
