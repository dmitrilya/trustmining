@php
    $gpuModels = \App\Models\Database\GPUModel::with([
        'gpuBrand:id,name,slug,country',
        'gpuEngineModel:id,name,slug,gpu_engine_brand_id',
    ])
        ->select(['id', 'name', 'slug', 'gpu_brand_id', 'gpu_engine_model_id', 'max_power'])
        ->get();

    $rModel = request()->get('gpu_model');
    $selModel = $rModel ? $gpuModels->where('slug', $rModel)->first() : null;
    $brands = $gpuModels->pluck('gpuBrand')->unique()->sortBy('name');
@endphp

@include('ad.gpus.selectmodel', [
    'selectedModel' => $selModel,
])

<x-filter-filter type="checkbox" :name="__('Power (kW/h)')" :items="[
    ['slug' => '><200-300', 'name' => '300' . __('kW/h')],
    ['slug' => '><300-500', 'name' => '500' . __('kW/h')],
    ['slug' => '><500-1000', 'name' => '1000' . __('kW/h')],
    ['slug' => '>1000', 'name' => __('more') . ' 1000' . __('kW/h')],
]" field="max_power"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Manufacturer')" :items="$brands" field="manufacturers"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Condition')" :items="collect([['name' => 'New', 'slug' => 'New'], ['name' => 'Used', 'slug' => 'Used']])" field="Condition"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Availability')" :items="collect([['name' => 'In stock', 'slug' => 'In stock'], ['name' => 'Preorder', 'slug' => 'Preorder']])" field="Availability"></x-filter-filter>
