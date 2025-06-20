@php
    $models = \App\Models\AsicModel::with(['asicVersions:id,asic_model_id,hashrate', 'algorithm:id,name'])->whereHas('ads')
        ->select(['id', 'name', 'algorithm_id'])->get()
        ->map(function ($model) {
            $model->url_name = strtolower(str_replace(' ', '_', $model->name));

            return $model;
        });

    if ($asicVersionId = request()->get('asic_version_id')) {
        $model = $models->filter(fn($model) => $model->asicVersions->where('id', $asicVersionId)->count())->first();
        $version = $model->asicVersions->where('id', $asicVersionId)->first();
        //dd($model->id, $version->id);
    }

    $algorithms = $models
        ->pluck('algorithm')
        ->unique()
        ->map(function ($algorithm) {
            $algorithm->url_name = strtolower($algorithm->name);

            return $algorithm;
        });
@endphp

@include('ad.components.selectversion', ['selectedModel' => isset($model) ? $model : null, 'selectedVersion' => isset($version) ? $version : null])

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
