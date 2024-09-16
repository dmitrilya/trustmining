@php
    $brands = \App\Models\AsicBrand::with(['asicModels', 'asicModels.algorithm', 'asicModels.asicVersions'])->get();
    $models = collect();

    foreach ($brands as $brand) {
        $models = $models->merge($brand->asicModels);
    }

    $algorithms = $models
        ->pluck('algorithm')
        ->unique()
        ->map(function ($algorithm) {
            $algorithm->url_name = strtolower($algorithm->name);

            return $algorithm;
        });

    $brands = $brands->map(function ($brand) {
        $brand->url_name = strtolower(str_replace(' ', '_', $brand->name));

        return $brand;
    });

    $models = $models->map(function ($model) {
        $model->url_name = strtolower(str_replace(' ', '_', $model->name));

        return $model;
    });
@endphp

<x-filter-filter :name="__('Brand')" :items="$brands" field="brands"></x-filter-filter>

<x-filter-filter :name="__('Model')" :items="$models" field="models"></x-filter-filter>

<x-filter-filter :name="__('Algorithm')" :items="$algorithms" field="algorithms"></x-filter-filter>

<x-filter-filter :name="__('Condition')" :items="collect([['name' => 'New', 'url_name' => 'new'], ['name' => 'Used', 'url_name' => 'used']])" field="conditions"></x-filter-filter>

<x-filter-filter :name="__('Availability')" :items="collect([
    ['name' => 'In stock', 'url_name' => 'in_stock'],
    ['name' => 'Preorder', 'url_name' => 'preorder'],
])" field="availabilities"></x-filter-filter>
