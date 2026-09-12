@php
    if ($type == 'user') {
        $user = App\Models\User\User::find($id);
        $href = route('company', ['user' => $user->slug]);
        $title = __('meta.review.index.title.user', ['name' => $user->name]);
        $description = __('meta.review.index.description.user', ['name' => $user->name]);
    } elseif ($type == 'asic-model') {
        $model = App\Models\Database\AsicModel::find($id);
        $href = route('database.asic-miners.model', ['asicBrand' => $model->asicBrand->slug, 'asicModel' => $model->slug]);
        $title = __('meta.review.index.title.asic', ['brand' => $model->asicBrand->name, 'model' => $model->name]);
        $description = __('meta.review.index.description.asic', ['brand' => $model->asicBrand->name, 'model' => $model->name]);
    } elseif ($type == 'gpu-model') {
        $model = App\Models\Database\GPUModel::find($id);
        $href = route('database.gas-gensets.model', ['gpuBrand' => $model->gpuBrand->slug, 'gpuModel' => $model->slug]);
        $title = __('meta.review.index.title.gpu', ['brand' => $model->gpuBrand->name, 'model' => $model->name]);
        $description = __('meta.review.index.description.gpu', ['brand' => $model->gpuBrand->name, 'model' => $model->name]);
    }
@endphp

<x-app-layout :title="{{ $title }}" :description="{{ $description }}">
    <x-slot name="header">
        <div class="flex items-center">
            <x-buttons.back-link :href="$href"></x-buttons.back-link>

            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight ml-3">
                {{ __('Reviews') }} {{ $name }}
            </h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="space-y-6">
            @include('review.reviews')
            @include('review.send')
        </div>
    </div>
</x-app-layout>
