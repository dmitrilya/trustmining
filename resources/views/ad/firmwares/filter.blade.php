@php
    $requestModels = request()['For_which_models'];
@endphp

<x-inputs.multiselect name="For_which_models" label="For which models" :all="App\Models\Database\AsicModel::pluck('name')->diff($requestModels)->values()" :selected="collect($requestModels)" />
