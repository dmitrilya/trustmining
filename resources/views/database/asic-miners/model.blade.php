<x-app-layout :title="__('meta.database.asic.model.title', ['b' => $brand->name, 'n' => $model->name, 'h' => $selectedVersion['h'], 'm' => $selectedVersion['m']])" :description="__('meta.database.asic.model.description', ['b' => $brand->name, 'n' => $model->name, 'h' => $selectedVersion['h'], 'm' => $selectedVersion['m']])"
    canonical="{{ route('database.asic-miners.version', [
        'asicBrand' => $brand->slug,
        'asicModel' => $model->slug,
        'asicVersion' => $selectedVersion['h'] . $selectedVersion['m'],
    ]) }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
            <x-breadcrumbs.breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $brand->slug])" :name="$brand->name" />
            @if (request()->routeIs('database.asic-miners.model'))
                <x-breadcrumbs.breadcrumb position="3" :name="$model->name" />
            @else
                <x-breadcrumbs.breadcrumb position="3" :href="route('database.asic-miners.model', [
                    'asicBrand' => $brand->slug,
                    'asicModel' => $model->slug,
                ])" :name="$model->name" />
                <x-breadcrumbs.breadcrumb position="4" :name="$selectedVersion['h'] . $selectedVersion['m']" />
            @endif
        </x-breadcrumbs.breadcrumbs>

        @include('database.asic-miners.model-info')
        @include('database.asic-miners.compare')
        @include('database.asic-miners.ads')
    </div>
</x-app-layout>
