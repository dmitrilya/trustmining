@php
    $gpuModels = \App\Models\Database\GPUModel::with([
        'gpuBrand:id,name,country',
        'gpuEngineModel:id,name,gpu_engine_brand_id',
    ])
        ->select(['id', 'name', 'gpu_brand_id', 'gpu_engine_model_id', 'max_power'])
        ->get()
        ->map(function ($model) {
            $model->url_name = strtolower(str_replace(' ', '_', $model->name));

            return $model;
        });

    $rModel = request()->get('gpu_model');
    $selModel = $rModel ? $gpuModels->where('url_name', $rModel)->first() : null;
    $brands = $gpuModels
        ->pluck('gpuBrand')
        ->unique()
        ->sortBy('name')
        ->map(function ($brand) {
            $brand->url_name = strtolower(str_replace(' ', '_', $brand->name));

            return $brand;
        });
@endphp

@include('ad.gpus.selectmodel', [
    'selectedModel' => $selModel,
])

<x-filter-filter type="checkbox" :name="__('Power (kW/h)')" :items="[
    ['url_name' => '><200-300', 'name' => '300' . __('kW/h')],
    ['url_name' => '><300-500', 'name' => '500' . __('kW/h')],
    ['url_name' => '><500-1000', 'name' => '1000' . __('kW/h')],
    ['url_name' => '>1000', 'name' => __('more') . ' 1000' . __('kW/h')],
]" field="max_power"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Manufacturer')" :items="$brands" field="manufacturers"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Condition')" :items="collect([['name' => 'New', 'url_name' => 'New'], ['name' => 'Used', 'url_name' => 'Used']])" field="Condition"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Availability')" :items="collect([
    ['name' => 'In stock', 'url_name' => 'In stock'],
    ['name' => 'Preorder', 'url_name' => 'Preorder'],
])" field="Availability"></x-filter-filter>
