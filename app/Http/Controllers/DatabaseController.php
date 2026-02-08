<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use App\Http\Traits\ViewTrait;

use App\Models\Database\Algorithm;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\AsicVersion;
use App\Models\Database\GPUBrand;
use App\Models\Database\GPUModel;

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
        $brands = AsicBrand::whereHas('asicModels', fn($q) => $q->where('release', '>', '2010-03-01'))
            ->with('asicModels', fn($q) => $q->where('release', '>', '2010-03-01')
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
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @return \Illuminate\Http\Response
     */
    public function brand(AsicBrand $asicBrand)
    {
        $this->addView(request(), $asicBrand);

        return view('database.brand', [
            'brand' => $asicBrand->load(['asicModels' => fn($q) => $q->where('release', '>', '2010-03-01')
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
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
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
                'ads.coin:id,abbreviation'
            ])->get()->sortByDesc('hashrate'),
            'algorithm' => $asicModel->algorithm()->with('coins')->first()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @param  \App\Models\Database\AsicVersion  $asicVersion
     * @return \Illuminate\Http\Response
     */
    public function version(AsicBrand $asicBrand, AsicModel $asicModel, AsicVersion $asicVersion)
    {
        $this->addView(request(), $asicModel);

        return view('database.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'selectedVersion' => $asicVersion,
            'versions' => $asicModel->asicVersions()->with([
                'ads' => fn($q) => $q->select(['asic_version_id', 'price', 'coin_id'])
                    ->orderByRaw('`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)'),
                'ads.coin:id,abbreviation'
            ])->get()->sortByDesc('hashrate'),
            'algorithm' => $asicModel->algorithm()->with('coins')->first()
        ]);
    }

    public function reviews(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        return view('review.index', [
            'auth' => \Auth::user(),
            'name' => $asicModel->name,
            'type' => 'App\Models\Database\AsicModel',
            'id' => $asicModel->id,
            'reviews' => $asicModel->reviews
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @return \Illuminate\Http\Response
     */
    public function gpuModel(GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        return view('database.gpu-model', [
            'brand' => $gpuBrand,
            'model' => $gpuModel->load(['ads' => fn($q) => $q->select(['gpu_model_id', 'price', 'coin_id'])
                ->orderByRaw('`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)')]),
        ]);
    }

    public function gpuReviews(GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        return view('review.index', [
            'auth' => \Auth::user(),
            'name' => $gpuModel->name,
            'type' => 'App\Models\Database\GPUModel',
            'id' => $gpuModel->id,
            'reviews' => $gpuModel->reviews
        ]);
    }

    public function getModels(Request $request)
    {
        $models = Cache::get('calculator_models');

        if ($request->asicBrand) $models = $models->where('asic_brand_id', AsicBrand::where('name', str_replace('_', ' ', $request->asicBrand))->first('id')->id);

        $models = $models->map(function ($model) {
            $version = $model->asicVersions->first();
            $profit = $version->profits->first();

            return [
                'name' => $model->name,
                'url_name' => $version->model_name,
                'hashrate' => $version->hashrate,
                'original_hashrate' => $version->original_hashrate,
                'profit' => $profit ? $profit['profit'] : 0,
                'coins' => $profit ? $profit['coins']->pluck('abbreviation') : [],
                'power' => $version->hashrate * $version->efficiency,
                'efficiency' => $version->efficiency,
                'original_efficiency' => $version->original_efficiency,
                'algorithm' => $version->algorithm,
                'measurement' => $version->measurement,
                'original_measurement' => $model->algorithm->measurement,
                'release' => $model->release,
                'brand' => $version->brand_name
            ];
        })->sortByDesc('profit')->values();

        return response()->json($models);
    }
}
