<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
use App\Models\Morph\View;

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
        $data = Cache::get('optimized_calculator_data');
        $modelData = $data['m']->where('i', $asicModel->id)->first();

        $versions = collect($modelData['v']);
        $selectedVersion = $versions->first();

        $ads = $this->getAds()->whereIn('ads.asic_version_id', $versions->pluck('i'))->where('ads.moderation', false)->orderByDesc('ads.ordering_id')->paginate(15);

        $asicModel->reviews_count = $modelData['r'];
        $asicModel->reviews_avg = $modelData['ra'];

        $comparing = Cache::remember(
            'compare_with_' . $asicModel->slug,
            now()->endOfWeek(),
            function () use ($asicModel, $versions, $data) {
                $asicModel->maxRate = $versions->max(fn($version) => $version['h'] * $version['c']);
                $models = AsicModel::select(['id', 'name', 'slug', 'asic_brand_id', 'algorithm_id', 'release', 'images'])->whereHas('asicVersions.ads')
                    ->with(['asicVersions:asic_model_id,hashrate', 'asicBrand:id,slug', 'algorithm:id,name,measurement'])->withCount('views')->get();
                $maxViews = log($models->max('views_count') + 1);
                
                if ($maxViews == 0) $maxViews = 1;

                return [
                    'same_algo' => $models->except($asicModel->id)->where('algorithm_id', $asicModel->algorithm_id)->sortByDesc(function ($model) use ($asicModel, $data, $maxViews) {
                        $model->maxRate = collect($data['m']->where('i', $model->id)->first()['v'])->max(fn($version) => $version['h'] * $version['c']);
                        $rateScore = min($model->maxRate, $asicModel->maxRate) / max($model->maxRate, $asicModel->maxRate) * 50;
                        $popularityScore = log($model->views_count + 1) / $maxViews * 10;

                        return $rateScore + $popularityScore;
                    })->take(10),
                    'diff_algo' => $models->except($asicModel->id)->where('algorithm_id', '!=', $asicModel->algorithm_id)->sortByDesc(function ($model) use ($asicModel, $data, $maxViews) {
                        $releaseScore = max(
                            0,
                            1 - abs($asicModel->release->diffInMonths($model->release)) / 48
                        ) * 30;
                        $popularityScore = log($model->views_count + 1) / $maxViews * 20;

                        return $releaseScore + $popularityScore;
                    })->take(10)
                ];
            }
        );

        return view('database.asic-miners.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'selectedVersion' => $selectedVersion,
            'comparing' => $comparing,
            'algorithms' => $data['a'],
            'versions' => $versions,
            'ads' => $ads,
            'rub' => $data['r']
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
        $ads = $this->getAds()->where('ads.gpu_model_id', $gpuModel->id)->where('ads.moderation', false)->orderByDesc('ads.ordering_id')->paginate(15);

        return view('database.gas-gensets.model', [
            'brand' => $gpuBrand,
            'model' => $gpuModel,
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
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
        $data = Cache::get('optimized_calculator_data');
        $modelData = $data['m']->where('i', $asicModel->id)->first();

        preg_match('/(\d+(?:\.\d+)?)([a-zA-Z]+)/', $asicVersion, $matches);
        if (!isset($matches[1])) abort(404);

        $versions = collect($modelData['v']);
        $selectedVersion = $versions->where('h', $matches[1])->first();
        if (!$selectedVersion) abort(404);

        $ads = $this->getAds()->whereIn('ads.asic_version_id', $versions->pluck('i'))->where('ads.moderation', false)->orderByDesc('ads.ordering_id')->paginate(15);

        $asicModel->reviews_count = $modelData['r'];
        $asicModel->reviews_avg = $modelData['ra'];

        $comparing = Cache::remember(
            'compare_with_' . $asicModel->slug,
            now()->endOfWeek(),
            function () use ($asicModel, $versions, $data) {
                $asicModel->maxRate = $versions->max(fn($version) => $version['h'] * $version['c']);
                $models = AsicModel::select(['id', 'name', 'slug', 'asic_brand_id', 'algorithm_id', 'release', 'images'])->whereHas('asicVersions.ads')
                    ->with(['asicVersions:asic_model_id,hashrate', 'asicBrand:id,slug', 'algorithm:id,name,measurement'])->withCount('views')->get();
                $maxViews = log($models->max('views_count') + 1);

                if ($maxViews == 0) $maxViews = 1;

                return [
                    'same_algo' => $models->except($asicModel->id)->where('algorithm_id', $asicModel->algorithm_id)->sortByDesc(function ($model) use ($asicModel, $data, $maxViews) {
                        $model->maxRate = collect($data['m']->where('i', $model->id)->first()['v'])->max(fn($version) => $version['h'] * $version['c']);
                        $rateScore = min($model->maxRate, $asicModel->maxRate) / max($model->maxRate, $asicModel->maxRate) * 50;
                        $popularityScore = log($model->views_count + 1) / $maxViews * 10;

                        return $rateScore + $popularityScore;
                    })->take(10),
                    'diff_algo' => $models->except($asicModel->id)->where('algorithm_id', '!=', $asicModel->algorithm_id)->sortByDesc(function ($model) use ($asicModel, $data, $maxViews) {
                        $releaseScore = max(
                            0,
                            1 - abs($asicModel->release->diffInMonths($model->release)) / 48
                        ) * 30;
                        $popularityScore = log($model->views_count + 1) / $maxViews * 20;

                        return $releaseScore + $popularityScore;
                    })->take(10)
                ];
            }
        );

        return view('database.asic-miners.model', [
            'brand' => $asicBrand,
            'model' => $asicModel,
            'selectedVersion' => $selectedVersion,
            'comparing' => $comparing,
            'algorithms' => $data['a'],
            'versions' => $versions,
            'ads' => $ads,
            'rub' => $data['r']
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

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request;
     * @param  string  $compareRequest
     * @return \Illuminate\Http\Response
     */
    public function compareAsics(Request $request, $compareRequest)
    {
        $noindex = null;
        $modelSlugs = explode('-vs-', $compareRequest);
        if (count($modelSlugs) != 2) abort(404);

        $modelA = AsicModel::where('slug', $modelSlugs[0])->select(['id', 'name', 'slug', 'characteristics'])->first();
        $modelB = AsicModel::where('slug', $modelSlugs[1])->select(['id', 'name', 'slug', 'characteristics'])->first();

        if (!$modelA || !$modelB) abort(404);

        if ($modelA->id > $modelB->id) $noindex = 'true';
        else {
            $popularModels = View::where('viewable_type', 'asic-model')->select('viewable_id', DB::raw('count(*) as views_count'))
                ->groupBy('viewable_id')->orderBy('views_count', 'desc')->limit(50)->get();

            if ($popularModels->whereIn('viewable_id', [$modelA->id, $modelB->id])->count() != 2) $noindex = 'true';
        }

        $calculatorModels = Cache::get('calculator_models');
        $modelA->data = $calculatorModels->where('id', $modelA->id)->first();
        $modelB->data = $calculatorModels->where('id', $modelB->id)->first();

        $ads = $this->getAds()->whereIn('asic_models.id', [$modelA->id, $modelB->id])->orderByDesc('ads.ordering_id')->get();

        return view('compare.index', [
            'modelA' => $modelA,
            'modelB' => $modelB,
            'models' => AsicModel::select(['id', 'name', 'slug'])->whereIn('id', $calculatorModels->filter(
                fn($model) => $model->asicVersions->contains(
                    fn($version) => $version->profits && $version->profits->isNotEmpty()
                )
            )->pluck('id'))->get(),
            'ads' => $ads,
            'rub' => Coin::where('abbreviation', 'RUB')->first('id')->rate,
            'noindex' => $noindex,
            'user' => $request->user()
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

        $algorithms = collect();
        $models = $models->map(function ($model) use ($algorithms) {
            $version = $model->asicVersions->first();
            $profit = $version->profits->first();

            $algorithms->put($version->algorithm_id, [
                'n' => $version->algorithm,
                'c' => $profit ? $profit['coins']->pluck('abbreviation') : []
            ]);

            return [
                'n' => $model->name,
                's' => $version->model_slug,
                'h' => $version->hashrate,
                'oh' => $version->original_hashrate,
                'p' => $profit ? $profit['profit'] : 0,
                'po' => $version->hashrate * $version->efficiency,
                'e' => $version->efficiency,
                'oe' => $version->original_efficiency,
                'a' => $version->algorithm_id,
                'm' => $version->measurement,
                'om' => $model->algorithm->measurement,
                'r' => $model->release,
                'b' => $version->brand_slug
            ];
        })->sortByDesc('p')->values();

        return response()->json(['m' => $models, 'a' => $algorithms]);
    }
}
