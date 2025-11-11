<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

use Carbon\Carbon;

use DB;

trait StatisticsTrait
{
    public function adsStatistics(Request $request)
    {
        $ads = $request->user()->ads()->where('moderation', false)->where('ad_category_id', 1)
            ->select(['id', 'preview', 'office_id', 'asic_version_id'])
            ->with([
                'views' => fn($q) => $q->select(DB::raw('*, Date(`created_at`) as date')),
                'tracks' => fn($q) => $q->select(DB::raw('*, Date(`created_at`) as date')),
                'phoneViews' => fn($q) => $q->select(DB::raw('*, Date(`created_at`) as date')),
                'chats' => fn($q) => $q->select(DB::raw('*, Date(`created_at`) as date')),
                'office:id,city',
                'asicVersion:id,hashrate,measurement,asic_model_id',
                'asicVersion.asicModel:id,name'
            ])->get()->map(function ($ad) {
                $ad->city = $ad->office->city;
                $ad->model = $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement;
                $ad->stat = $ad->views->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'views_count' => $day->sum('count')])
                    ->mergeRecursive($ad->views->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'visits_count' => $day->count()]))
                    ->mergeRecursive($ad->phoneViews->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'phone_views_count' => $day->count()]))
                    ->mergeRecursive($ad->tracks->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'tracks_count' => $day->count()]))
                    ->mergeRecursive($ad->chats->groupBy('date')->map(fn($day, $date) => ['date' => Carbon::create($date)->timestamp * 1000, 'chats_count' => $day->count()]))
                    ->values()->map(function ($day) {
                        $day['date'] = is_array($day['date']) ? $day['date'][0] : $day['date'];
                        return $day;
                    });

                return $ad;
            });

        return response()->json(['ads' => $ads, 'graph_data' => $ads->pluck('stat')->flatten(1)->groupBy('date')->map(fn($day, $date) => [
            'date' => $date,
            'views' => $day->sum('views_count'),
            'visits' => $day->sum('visits_count'),
            'phone_views' => $day->sum('phone_views_count'),
            'tracks' => $day->sum('tracks_count'),
            'chats' => $day->sum('chats_count'),
        ])->sortBy('date')->values()], 200);
    }
}
