@php
    $models = \App\Models\Database\AsicModel::where('release', '>', '2010-03-01')
        ->select(['id', 'name', 'slug'])
        ->get();

    $rModel = request()->get('model');
    $selModel = $rModel ? $models->where('slug', $rModel)->first() : null;
@endphp

@include('ad.firmwares.select-model', [
    'models' => $models,
    'selectedModel' => $selModel,
])
