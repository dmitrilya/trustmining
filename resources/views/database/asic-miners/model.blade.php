<x-app-layout
    title="{{ $brand->name }} {{ $model->name }} {{ $selectedVersion['h'] }}{{ $selectedVersion['m'] }}/s - доходность и объявления"
    description="{{ $brand->name }} {{ $model->name }} {{ $selectedVersion['h'] }}{{ $selectedVersion['m'] }}/s. Характеристики, потребление, доходность и окупаемость. Актуальные предложения и цены. Купить {{ $model->name }} с доставкой по РФ на TRUSTMINING"
    canonical="{{ route('database.asic-miners.version', [
        'asicBrand' => $brand->slug,
        'asicModel' => $model->slug,
        'asicVersion' => $selectedVersion['h'] . $selectedVersion['m'],
    ]) }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
            <x-breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $brand->slug])" :name="$brand->name" />
            @if (request()->routeIs('database.asic-miners.model'))
                <x-breadcrumb position="3" :name="$model->name" />
            @else
                <x-breadcrumb position="3" :href="route('database.asic-miners.model', [
                    'asicBrand' => $brand->slug,
                    'asicModel' => $model->slug,
                ])" :name="$model->name" />
                <x-breadcrumb position="4" :name="$selectedVersion['h'] . $selectedVersion['m']" />
            @endif
        </x-breadcrumbs>

        @include('database.asic-miners.model-info')
        @include('database.asic-miners.compare')
        @include('database.asic-miners.ads')
    </div>
</x-app-layout>
