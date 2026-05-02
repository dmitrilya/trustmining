@php
    if ($type == 'user') {
        $user = App\Models\User\User::find($id);
        $href = route('company', ['user' => $user->slug]);
        $title = 'компании ' . $user->name . ' - мнения клиентов и экспертов';
        $description =
            'Реальные отзывы о компании ' .
            $user->name .
            ' от клиентов, партнёров и экспертов: качество услуг, надёжность, условия сотрудничества и опыт работы';
    } elseif ($type == 'asic-model') {
        $model = App\Models\Database\AsicModel::find($id);
        $href = route('database.asic-miners.model', [
            'asicBrand' => $model->asicBrand->slug,
            'asicModel' => $model->slug,
        ]);
        $title = 'ASIC майнере ' . $model->asicBrand->name . ' ' . $model->name . ' - реальный опыт, плюсы и минусы';
        $description =
            'Отзывы майнеров о модели ASIC ' .
            $model->asicBrand->name .
            ' ' .
            $model->name .
            ': реальный опыт эксплуатации, доходность, энергопотребление, надёжность и мнения экспертов';
    } elseif ($type == 'gpu-model') {
        $model = App\Models\Database\GPUModel::find($id);
        $href = route('database.gas-gensets.model', [
            'gpuBrand' => $model->gpuBrand->slug,
            'gpuModel' => $model->slug,
        ]);
        $title =
            'газопоршневой электростанции ' .
            $model->gpuBrand->name .
            ' ' .
            $model->name .
            ' - реальный опыт, плюсы и минусы';
        $description =
            'Отзывы майнеров о модели ГПУ ' .
            $model->gpuBrand->name .
            ' ' .
            $model->name .
            ': реальный опыт эксплуатации, надёжность и мнения экспертов';
    } else {
        $model = null;
        $href = '#';
        $title = null;
        $description = null;
    }
@endphp

<x-app-layout title="Отзывы о {{ $title }}" description="{{ $description }} на платформе TrustMining">
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-link :href="$href"></x-back-link>

            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight ml-3">
                {{ __('Reviews') }} {{ $name }}
            </h1>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div
            class="space-y-6">
            @include('review.reviews')
            @include('review.send')
        </div>
    </div>
</x-app-layout>
