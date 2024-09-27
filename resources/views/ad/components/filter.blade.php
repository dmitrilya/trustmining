@php
    $brands = \App\Models\AsicBrand::with(['asicModels', 'asicModels.algorithm', 'asicModels.asicVersions'])
        ->get()
        ->map(function ($brand) {
            $brand->url_name = strtolower(str_replace(' ', '_', $brand->name));

            return $brand;
        });

    $models = collect();

    foreach ($brands->whereIn('url_name', request()->brands) as $brand) {
        $models = $models->merge($brand->asicModels);
    }

    $algorithms = $models
        ->pluck('algorithm')
        ->unique()
        ->map(function ($algorithm) {
            $algorithm->url_name = strtolower($algorithm->name);

            return $algorithm;
        });

    $models = $models->map(function ($model) {
        $model->url_name = strtolower(str_replace(' ', '_', $model->name));

        return $model;
    });
@endphp

<x-filter-filter type="checkbox" :name="__('Brand')" :items="$brands" field="brands"></x-filter-filter>

@if ($models->count())
    <x-filter-filter type="checkbox" :name="__('Model')" :items="$models" field="models"></x-filter-filter>
@endif

<x-filter-filter type="checkbox" :name="__('Algorithm')" :items="$algorithms" field="algorithms"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Condition')" :items="collect([['name' => 'New', 'url_name' => 'new'], ['name' => 'Used', 'url_name' => 'used']])" field="conditions"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Availability')" :items="collect([
    ['name' => 'In stock', 'url_name' => 'in_stock'],
    ['name' => 'Preorder', 'url_name' => 'preorder'],
])" field="availabilities"></x-filter-filter>

@if (in_array(request()->route()->action['as'], ['company']) &&
        ($user = \Auth::user()) &&
        $user->id == request()->user->id)
    <x-filter-filter type="radio" :name="__('Display')" :items="collect([
        ['name' => 'View all', 'url_name' => ''],
        ['name' => 'Active', 'url_name' => 'active'],
        ['name' => 'Is under moderation', 'url_name' => 'moderation'],
        ['name' => 'Rejected', 'url_name' => 'rejected'],
        ['name' => 'Hidden', 'url_name' => 'hidden'],
    ])" field="display"></x-filter-filter>
@endif
