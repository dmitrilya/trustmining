<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

use App\Http\Traits\ViewTrait;
use App\Http\Traits\AdTrait;

use App\Models\Ad\AdCategory;
use App\Models\Database\AsicBrand;
use App\Models\Database\AsicModel;
use App\Models\Database\Coin;
use App\Models\Database\GPUBrand;
use App\Models\Database\GPUModel;

class DatabaseController extends Controller
{
    use ViewTrait, AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function asicMinersIndex()
    {
        $brands = AsicBrand::whereHas('asicModels', fn($q) => $q->where('release', '>', '2010-03-01'))
            ->with('asicModels', fn($q) => $q->where('release', '>', '2010-03-01')
                ->select(['id', 'slug', 'asic_brand_id', 'algorithm_id'])
                ->with(['algorithm', 'algorithm.coins']))
            ->withCount('views')->orderByDesc('views_count')->get();

        return view('database.asic-miners.index', [
            'brands' => $brands,
            'algos' => $brands->pluck('asicModels.*.algorithm')->flatten()->unique('name')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function gpusIndex()
    {
        $brands = GPUBrand::whereHas('gpuModels')->with('gpuModels', fn($q) => $q->select(['id', 'name', 'slug', 'gpu_brand_id', 'max_power', 'fuel_consumption']))
            ->withCount('views')->orderByDesc('views_count')->get()->each(fn($gpuBrand) => $gpuBrand->gpuModels->map(function ($model) use ($gpuBrand) {
                $model->brand_slug = $gpuBrand->slug;
                $model->brand_name = $gpuBrand->name;
                return $model;
            }));

        return view('database.gas-gensets.index', ['brands' => $brands]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @return \Illuminate\Http\Response
     */
    public function asicMinersBrand(AsicBrand $asicBrand)
    {
        $this->addView(request(), $asicBrand);

        return view('database.asic-miners.brand', [
            'brand' => $asicBrand->load(['asicModels' => fn($q) => $q->where('release', '>', '2010-03-01')
                ->select(['id', 'slug', 'asic_brand_id', 'algorithm_id'])
                ->with(['algorithm', 'algorithm.coins'])]),
            'algos' => $asicBrand->asicModels->pluck('algorithm')->flatten()->unique('name')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @return \Illuminate\Http\Response
     */
    public function gpusBrand(GPUBrand $gpuBrand)
    {
        $this->addView(request(), $gpuBrand);

        $gpuBrand->load(['gpuModels' => fn($q) => $q->select(['id', 'name', 'slug', 'gpu_brand_id', 'max_power', 'fuel_consumption'])]);

        $gpuBrand->gpuModels->map(function ($model) use ($gpuBrand) {
            $model->brand_slug = $gpuBrand->slug;
            $model->brand_name = $gpuBrand->name;
            return $model;
        });

        return view('database.gas-gensets.brand', [
            'brand' => $gpuBrand
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @return \Illuminate\Http\Response
     */
    public function asicMinersModel(Request $request, AsicBrand $asicBrand, AsicModel $asicModel)
    {
        $versions = $asicModel->asicVersions()->with([
            'ads' => fn($q) => $q->select(['asic_version_id', 'price', 'coin_id'])
                ->orderByRaw('`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)'),
            'ads.coin:id,abbreviation,rate'
        ])->get()->sortByDesc('hashrate');

        $this->addView(request(), $asicModel);

        $selectedVersion = $versions->first();
        $ads = $this->getAds()->whereIn('ads.asic_version_id', $versions->pluck('id'))->where('ads.moderation', false)->orderByDesc('ads.ordering_id')->paginate(15);

        $calculatorModel = Cache::get('calculator_models')->where('id', $asicModel->id)->first();
        $versions = $versions->map(function ($version) use ($calculatorModel) {
            $version->data = $calculatorModel->asicVersions->where('id', $version->id)->first();
            return $version;
        });

        return view('database.asic-miners.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'selectedVersion' => $selectedVersion,
            'versions' => $versions,
            'algorithm' => $asicModel->algorithm()->with('coins')->first(),
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @return \Illuminate\Http\Response
     */
    public function gpusModel(Request $request, GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        $this->addView(request(), $gpuModel);

        $ads = $this->getAds()->where('ads.gpu_model_id', $gpuModel->id)->where('ads.moderation', false)->orderByDesc('ads.ordering_id')->paginate(15);

        return view('database.gas-gensets.model', [
            'brand' => $gpuBrand,
            'model' => $gpuModel,
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @return \Illuminate\Http\Response
     */
    public function getAsicMinersModelAds(Request $request, AsicBrand $asicBrand, AsicModel $asicModel)
    {
        $ads = $this->getAds()->whereIn('ads.asic_version_id', $asicModel->asicVersions()->pluck('id'))->orderByDesc('ads.ordering_id')->paginate(15);

        return response()->json([
            'html' => view('ad.components.list', ['adCategory' => AdCategory::where('name', 'miners')->first(), 'ads' => $ads, 'user' => $request->user(), 'owner' => false])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @return \Illuminate\Http\Response
     */
    public function getGpusModelAds(Request $request, GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        $ads = $this->getAds()->where('ads.gpu_model_id', $gpuModel->id)->orderByDesc('ads.ordering_id')->paginate(15);

        return response()->json([
            'html' => view('ad.components.list', ['adCategory' => AdCategory::where('name', 'gpus')->first(), 'ads' => $ads, 'user' => $request->user(), 'owner' => false])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @param  string  $asicVersion (hashrate + measurement)
     * @return \Illuminate\Http\Response
     */
    public function asicMinersVersion(Request $request, AsicBrand $asicBrand, AsicModel $asicModel, $asicVersion)
    {
        $versions = $asicModel->asicVersions()->with([
            'ads' => fn($q) => $q->select(['asic_version_id', 'price', 'coin_id'])
                ->orderByRaw('`price` * (SELECT `rate` from `coins` where `coins`.`id` = `ads`.`coin_id` LIMIT 1)'),
            'ads.coin:id,abbreviation,rate'
        ])->get()->sortByDesc('hashrate');

        preg_match('/(\d+(?:\.\d+)?)([a-zA-Z]+)/', $asicVersion, $matches);
        if (!isset($matches[1])) abort(404);
        $selectedVersion = $versions->where('hashrate', $matches[1])->first();
        if (!$selectedVersion) abort(404);

        $this->addView(request(), $asicModel);
        $ads = $this->getAds()->whereIn('ads.asic_version_id', $versions->pluck('id'))->orderByDesc('ads.ordering_id')->paginate(15);

        $calculatorModel = Cache::get('calculator_models')->where('id', $asicModel->id)->first();
        $versions = $versions->map(function ($version) use ($calculatorModel) {
            $version->data = $calculatorModel->asicVersions->where('id', $version->id)->first();
            return $version;
        });

        return view('database.asic-miners.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'selectedVersion' => $selectedVersion,
            'versions' => $versions,
            'algorithm' => $asicModel->algorithm()->with('coins')->first(),
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('rate')->rate,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  \App\Models\Database\AsicBrand  $asicBrand
     * @param  \App\Models\Database\AsicModel  $asicModel
     * @param  string  $asicModel
     * @return \Illuminate\Http\Response
     */
    public function getAsicMinersVersionAds(Request $request, AsicBrand $asicBrand, AsicModel $asicModel, string $asicVersion)
    {
        preg_match('/(\d+)([a-zA-Z]+)/', $asicVersion, $matches);
        if (!isset($matches[1])) abort(404);
        $version = $asicModel->asicVersions()->where('hashrate', $matches[1])->first();
        if (!$version) abort(404);

        $ads = $this->getAds()->where('ads.asic_version_id', $version->id)->orderByDesc('ads.ordering_id')->paginate(15);

        return response()->json([
            'html' => view('ad.components.list', ['adCategory' => AdCategory::where('name', 'miners')->first(), 'ads' => $ads, 'user' => $request->user(), 'owner' => false])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);
    }

    public function asicMinersReviews(AsicBrand $asicBrand, AsicModel $asicModel)
    {
        return view('review.index', [
            'auth' => Auth::user(),
            'name' => $asicModel->name,
            'type' => 'asic-model',
            'id' => $asicModel->id,
            'reviews' => $asicModel->reviews
        ]);
    }

    public function gpusReviews(GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        return view('review.index', [
            'auth' => Auth::user(),
            'name' => $gpuModel->name,
            'type' => 'gpu-model',
            'id' => $gpuModel->id,
            'reviews' => $gpuModel->reviews
        ]);
    }

    public function getAsicMinersModels(Request $request)
    {
        $models = Cache::get('calculator_models');

        if ($request->asicBrand) $models = $models->where('asic_brand_id', AsicBrand::where('slug', $request->asicBrand)->first('id')->id);

        $models = $models->map(function ($model) {
            $version = $model->asicVersions->first();
            $profit = $version->profits->first();

            return [
                'name' => $model->name,
                'slug' => $version->model_slug,
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
                'brand_slug' => $version->brand_slug
            ];
        })->sortByDesc('profit')->values();

        return response()->json($models);
    }
}
