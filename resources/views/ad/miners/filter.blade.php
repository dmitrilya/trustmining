@php
    $models = \App\Models\Database\AsicModel::where('release', '>', '2010-03-01')
        ->with(['asicBrand:id,name', 'asicVersions:id,asic_model_id,hashrate', 'algorithm:id,name'])
        ->select(['id', 'name', 'algorithm_id', 'asic_brand_id'])
        ->get()
        ->map(function ($model) {
            $model->url_name = strtolower(str_replace(' ', '_', $model->name));

            return $model;
        });

    $rModel = request()->get('model');
    $rVerId = request()->get('asic_version_id');
    $selModel = !$rModel
        ? ($rVerId
            ? $models->filter(fn($model) => $model->asicVersions->where('id', $rVerId)->count())->first()
            : null)
        : $models->where('url_name', $rModel)->first();
    $selVersion = $rVerId && $selModel ? $selModel->asicVersions->where('id', $rVerId)->first() : null;

    $algorithms = $models
        ->pluck('algorithm')
        ->unique()
        ->map(function ($algorithm) {
            $algorithm->url_name = strtolower($algorithm->name);

            return $algorithm;
        });

    $brands = $models
        ->pluck('asicBrand')
        ->unique()->sortBy('name')
        ->map(function ($brand) {
            $brand->url_name = strtolower(str_replace(' ', '_', $brand->name));

            return $brand;
        });
@endphp

@include('ad.miners.selectversion', [
    'selectedModel' => $selModel,
    'selectedVersion' => $selVersion,
    'withAllVersions' => true,
])

<x-filter-filter type="checkbox" :name="__('Algorithm')" :items="$algorithms" field="algorithms"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Manufacturer')" :items="$brands" field="brands"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Condition')" :items="collect([['name' => 'New', 'url_name' => 'New'], ['name' => 'Used', 'url_name' => 'Used']])" field="Condition"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Availability')" :items="collect([
    ['name' => 'In stock', 'url_name' => 'In stock'],
    ['name' => 'Preorder', 'url_name' => 'Preorder'],
])" field="Availability"></x-filter-filter>

@if (in_array(request()->route()->action['as'], ['company']) &&
        ($user = Auth::user()) &&
        $user->id == request()->user->id)
    <x-filter-filter type="radio" :name="__('Display')" :items="collect([
        ['name' => 'View all', 'url_name' => ''],
        ['name' => 'Active', 'url_name' => 'active'],
        ['name' => 'Is under moderation', 'url_name' => 'moderation'],
        ['name' => 'Rejected', 'url_name' => 'rejected'],
        ['name' => 'Hidden', 'url_name' => 'hidden'],
    ])" field="display"></x-filter-filter>
@endif
