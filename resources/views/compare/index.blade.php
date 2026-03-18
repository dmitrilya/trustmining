<x-app-layout :noindex="$noindex"
    title="Сравнение {{ $modelA->data->asicBrand->name }} {{ $modelA->data->name }} и {{ $modelB->data->asicBrand->name }} {{ $modelB->data->name }}: что лучше купить в {{ now()->year }}? Характеристики, окупаемость и цены | TRUSTMINING"
    description="Подробное сравнение ASIC майнеров {{ $modelA->data->asicBrand->name }} {{ $modelA->data->name }} и {{ $modelB->data->asicBrand->name }} {{ $modelB->data->name }}. Сравните доходность, энергопотребление и срок окупаемости. Актуальные цены от проверенных поставщиков в нашем агрегаторе.">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Which is better?') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-lg p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6" x-data="{ model_a: '{{ $modelA->slug }}', model_b: '{{ $modelB->slug }}' }">
                @include('compare.components.select-model', [
                    'name' => 'model_a',
                    'selectedModel' => $modelA,
                ])
                @include('compare.components.select-model', [
                    'name' => 'model_b',
                    'selectedModel' => $modelB,
                ])
                <x-primary-button
                    @click="model_a && model_b ? window.location.href=`/asic-miners/compare/${model_a}-vs-${model_b}` : pushToastAlert('{{ __('Select models to compare') }}', 'error')">
                    {{ __('Compare') }}
                </x-primary-button>
            </div>
        </div>

        <div class="mt-2 sm:mt-4 lg:mt-6 grid grid-cols-2 gap-1 xs:gap-2 sm:gap-4 lg:gap-6">
            @include('compare.components.model-data', ['model' => $modelA])
            @include('compare.components.model-data', ['model' => $modelB])
        </div>

        <div class="flex items-center justify-between px-4 lg:px-5 gap-4 my-2 sm:mb-3 sm:mt-4 lg:mt-6">
            <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                {{ __('Conclusion') }}
            </h2>
        </div>

        @inject('textGenerator', 'App\Services\ComparisonTextService')

        <div class="border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-lg p-4 lg:p-6">
            <p class="text-xs:xs:text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line">{{ $textGenerator->generate($modelA, $modelB, $ads) }}</p>
        </div>

        <div class="flex items-center justify-between px-4 lg:px-5 gap-4 my-2 sm:mb-3 sm:mt-4 lg:mt-6">
            <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                {{ __('Offers') }}
            </h2>
        </div>

        <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @include('ad.components.list', ['owner' => false])
        </div>
    </div>
</x-app-layout>
