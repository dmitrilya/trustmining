<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Database\Eloquent\Builder;

use App\Http\Traits\ViewTrait;

use App\Models\AsicBrand;
use App\Models\AsicModel;
use App\Models\AsicVersion;

class DatabaseController extends Controller
{
    use ViewTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = AsicBrand::whereHas('asicModels', fn($q) => $q->where('release', '>', '2018-03-01'))
            ->with('asicModels', fn($q) => $q->where('release', '>', '2018-03-01')
                ->select(['id', 'asic_brand_id', 'algorithm_id', 'release'])
                ->with([
                    'algorithm',
                    'algorithm.coins'
                ]))
            ->withCount('views')->orderByDesc('views_count')->get();

        return view('database.index', [
            'brands' => $brands,
            'algos' => $brands->pluck('asicModels.*.algorithm')->flatten()->unique('name')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\AsicBrand  $asicBrand
     * @return \Illuminate\Http\Response
     */
    public function brand(AsicBrand $asicBrand)
    {
        $this->addView(request(), $asicBrand);

        return view('database.brand', [
            'brand' => $asicBrand->load(['asicModels' => fn($q) => $q->where('release', '>', '2018-03-01')
                ->select(['id', 'name', 'asic_brand_id', 'algorithm_id'])
                ->with([
                    'algorithm',
                    'algorithm.coins'
                ])]),
            'algos' => $asicBrand->asicModels->pluck('algorithm')->flatten()->unique('name')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AsicBrand  $asicBrand
     * @param  \App\Models\AsicModel  $asicModel
     * @return \Illuminate\Http\Response
     */
    public function model(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        $this->addView(request(), $asicModel);

        return view('database.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'versions' => $asicModel->asicVersions()->with([
                'ads' => fn($q) => $q->select(['asic_version_id', 'price', 'coin_id'])
                    ->orderByRaw('`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)'),
                'ads.coin:id,abbreviation'])->get()->sortByDesc('hashrate'),
            'algorithm' => $asicModel->algorithm()->with('coins')->first()
        ]);
    }

    public function reviews(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        return view('review.index', [
            'auth' => \Auth::user(),
            'name' => $asicModel->name,
            'type' => 'App\Models\AsicModel',
            'id' => $asicModel->id,
            'reviews' => $asicModel->reviews
        ]);
    }

    public function getModels(Request $request)
    {
        $measurements = ['h', 'kh', 'Mh', 'Gh', 'Th', 'Ph', 'Eh', 'Zh'];

        $asicModels = AsicModel::where('release', '>', '2018-03-01');

        if ($request->asicBrand) $asicModels = $asicModels->where('asic_brand_id', AsicBrand::where('name', str_replace('_', ' ', $request->asicBrand))->first('id')->id);

        return response()->json($asicModels->withCount('views')->with([
            'asicBrand:id,name',
            'algorithm:id,name,measurement',
            'algorithm.coins:abbreviation,algorithm_id,profit,rate,merged_group',
            'asicVersions' => fn($q) => $q->select(['asic_model_id', 'hashrate', 'efficiency', 'measurement'])->orderByDesc('hashrate')
        ])->get()->map(function ($model) use ($measurements) {
            $version = $model->asicVersions->first();
            $vm = array_search($version->measurement, $measurements);
            $am = array_search($model->algorithm->measurement, $measurements);
            $maxProfit = $model->algorithm->coins->groupBy('merged_group')->map(
                fn($mergedGroup) => [
                    'profit' => $mergedGroup->sum(fn($coin) => $coin->profit * $coin->rate),
                    'coins' => $mergedGroup->pluck('abbreviation')
                ]
            )->sortByDesc('profit')->first();

            return [
                'name' => $model->name,
                'url_name' => strtolower(str_replace(' ', '_', $model->name)),
                'hashrate' => $version->hashrate,
                'original_hashrate' => $version->hashrate * pow(1000, $vm),
                'profit' => round($maxProfit['profit'] * $version->hashrate * pow(1000, $vm - $am), 2),
                'coins' => $maxProfit['coins'],
                'power' => $version->hashrate * $version->efficiency,
                'efficiency' => $version->efficiency,
                'original_efficiency' => $version->efficiency * pow(1000, $am - $vm),
                'algorithm' => $model->algorithm->name,
                'measurement' => $version->measurement,
                'original_measurement' => $model->algorithm->measurement,
                'release' => $model->release,
                'brand' => strtolower(str_replace(' ', '_', $model->asicBrand->name))
            ];
        })->sortByDesc('profit')->values());
    }
}
