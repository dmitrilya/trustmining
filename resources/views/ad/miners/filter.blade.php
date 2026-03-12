@php
    $models = \App\Models\Database\AsicModel::where('release', '>', '2010-03-01')
        ->with(['asicBrand:id,name,slug', 'asicVersions:id,asic_model_id,hashrate', 'algorithm:id,name,slug'])
        ->select(['id', 'name', 'algorithm_id', 'asic_brand_id'])
        ->get();

    $rModel = request()->get('model');
    $rVerId = request()->get('asic_version_id');
    $selModel = !$rModel
        ? ($rVerId
            ? $models->filter(fn($model) => $model->asicVersions->where('id', $rVerId)->count())->first()
            : null)
        : $models->where('slug', $rModel)->first();
    $selVersion = $rVerId && $selModel ? $selModel->asicVersions->where('id', $rVerId)->first() : null;

    $algorithms = $models->pluck('algorithm')->unique();
    $brands = $models->pluck('asicBrand')->unique()->sortBy('name');
@endphp

@include('ad.miners.selectversion', [
    'selectedModel' => $selModel,
    'selectedVersion' => $selVersion,
    'withAllVersions' => true,
])

<x-filter-filter type="checkbox" :name="__('Algorithm')" :items="$algorithms" field="algorithms"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Manufacturer')" :items="$brands" field="brands"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Condition')" :items="collect([['name' => 'New', 'slug' => 'New'], ['name' => 'Used', 'slug' => 'Used']])" field="Condition"></x-filter-filter>

<x-filter-filter type="checkbox" :name="__('Availability')" :items="collect([['name' => 'In stock', 'slug' => 'In stock'], ['name' => 'Preorder', 'slug' => 'Preorder']])" field="Availability"></x-filter-filter>

@if (in_array(request()->route()->action['as'], ['company']) &&
        ($user = Auth::user()) &&
        $user->id == request()->user->id)
    <x-filter-filter type="radio" :name="__('Display')" :items="collect([
        ['name' => 'View all', 'slug' => ''],
        ['name' => 'Active', 'slug' => 'active'],
        ['name' => 'Is under moderation', 'slug' => 'moderation'],
        ['name' => 'Rejected', 'slug' => 'rejected'],
        ['name' => 'Hidden', 'slug' => 'hidden'],
    ])" field="display"></x-filter-filter>
@endif
