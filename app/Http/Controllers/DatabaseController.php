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
        $brands = AsicBrand::whereHas('asicModels', fn($q) => $q->where('release', '>', '2020-03-01'))
            ->with('asicModels', fn($q) => $q->where('release', '>', '2020-03-01')
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
            'brand' => $asicBrand,
            'algos' => $asicBrand->asicModels()->where('release', '>', '2020-03-01')
                ->select(['id', 'asic_brand_id', 'algorithm_id'])
                ->with([
                    'algorithm',
                    'algorithm.coins'
                ])->get()->pluck('algorithm')->flatten()->unique('name')
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

        return view('database.model', ['brand' => $asicBrand, 'model' => $asicModel, 'versions' => $asicModel->asicVersions]);
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
        return response()->json(AsicModel::where('release', '>', '2020-03-01')->withCount('views')->with([
            'asicBrand:id,name',
            'algorithm',
            'asicVersions' => fn($q) => $q->select(['asic_model_id', 'hashrate', 'efficiency', 'measurement'])->orderByDesc('hashrate')
        ])->get()->map(fn($model) => [
            'name' => $model->name,
            'url_name' => strtolower(str_replace(' ', '_', $model->name)),
            'hashrate' => $model->asicVersions->first()->hashrate,
            'power' => $model->asicVersions->first()->hashrate * $model->asicVersions->first()->efficiency,
            'efficiency' => $model->asicVersions->first()->efficiency,
            'algorithm' => $model->algorithm->name,
            'measurement' => $model->asicVersions->first()->measurement,
            'original_measurement' => $model->algorithm->measurement,
            'release' => $model->release,
            'brand' => strtolower(str_replace(' ', '_', $model->asicBrand->name))
        ]));
    }

    public function getBrandModels(Request $request, AsicBrand $asicBrand)
    {
        return response()->json($asicBrand->asicModels()->where('release', '>', '2020-03-01')->withCount('views')->with([
            'asicBrand:id,name',
            'algorithm',
            'asicVersions' => fn($q) => $q->select(['asic_model_id', 'hashrate', 'efficiency', 'measurement'])->orderByDesc('hashrate')
        ])->get()->map(fn($model) => [
            'name' => $model->name,
            'url_name' => strtolower(str_replace(' ', '_', $model->name)),
            'hashrate' => $model->asicVersions->first()->hashrate,
            'power' => $model->asicVersions->first()->hashrate * $model->asicVersions->first()->efficiency,
            'efficiency' => $model->asicVersions->first()->efficiency,
            'algorithm' => $model->algorithm->name,
            'measurement' => $model->asicVersions->first()->measurement,
            'original_measurement' => $model->algorithm->measurement,
            'release' => $model->release,
            'brand' => strtolower(str_replace(' ', '_', $model->asicBrand->name))
        ]));
    }
}
