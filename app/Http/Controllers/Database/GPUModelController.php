<?php

namespace App\Http\Controllers\Database;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Traits\AdTrait;

use App\Models\Ad\AdCategory;
use App\Models\Database\Coin;
use App\Models\Database\GPUBrand;
use App\Models\Database\GPUModel;

class GPUModelController
{
    use AdTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @return \Illuminate\Http\Response
     */
    public function brand(GPUBrand $gpuBrand)
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
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @return \Illuminate\Http\Response
     */
    public function model(Request $request, GPUBrand $gpuBrand, GPUModel $gpuModel)
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
     * @param  \App\Models\Database\GPUBrand  $gpuBrand
     * @param  \App\Models\Database\GPUModel  $gpuModel
     * @return \Illuminate\Http\Response
     */
    public function getModelAds(Request $request, GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        $ads = $this->getAds()->where('ads.gpu_model_id', $gpuModel->id)->orderByDesc('ads.ordering_id')->paginate(15);

        return response()->json([
            'html' => view('ad.components.list', ['adCategory' => AdCategory::where('name', 'gpus')->first(), 'ads' => $ads, 'user' => $request->user(), 'owner' => false])->render(),
            'hasMore' => $ads->hasMorePages()
        ]);
    }

    public function reviews(GPUBrand $gpuBrand, GPUModel $gpuModel)
    {
        return view('review.index', [
            'auth' => Auth::user(),
            'name' => $gpuModel->name,
            'type' => 'gpu-model',
            'id' => $gpuModel->id,
            'reviews' => $gpuModel->reviews
        ]);
    }
}
