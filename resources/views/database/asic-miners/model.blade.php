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

        @if (session('from_deleted_ad'))
            <div class="bg-amber-500/10 border-l-4 border-amber-500/30 p-4 rounded-r-md mb-2 sm:mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">⚠️</div>
                    <div class="ml-3">
                        <p class="text-sm sm:text-base text-amber-800 dark:text-amber-200 font-bold">{{ __('The ad has been removed') }}</p>
                        <p class="text-xs sm:text-sm text-amber-500 mt-1">
                            {{ __('We invite you to check out other offers for sale of') }} {{ $brand->name }} {{ $model->name }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @include('database.asic-miners.model-info')
        @include('database.asic-miners.compare')
        @include('database.asic-miners.ads')
        @include('database.asic-miners.faq')
    </div>
</x-app-layout>
