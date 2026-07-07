@php
    $seoParams = request()->only(['model', 'gpu_model', 'page', 'Category']);
    if (isset($seoParams['page']) && $seoParams['page'] == 1) {
        unset($seoParams['page']);
    }
    if (isset($seoParams['Category']) && count($seoParams['Category']) > 1) {
        unset($seoParams['Category']);
    }

    $model = isset($seoParams['model'])
        ? \App\Models\Database\AsicModel::where('slug', $seoParams['model'])->first('name')
        : (isset($seoParams['gpu_model'])
            ? \App\Models\Database\GPUModel::where('slug', $seoParams['gpu_model'])->first('name')
            : null);

    $addParams = [];
    if ($model) {
        array_push($addParams, $model->name);
    }
    if (isset($seoParams['Category'])) {
        array_push($addParams, __(str_replace('_', ' ', $seoParams['Category'][0])));
    }
    if (isset($seoParams['page'])) {
        array_push($addParams, "ст {$seoParams['page']}");
    }

    $addParams = count($addParams) ? ': ' . implode(', ', $addParams) : '';
    $canonicalUrl = request()->url() . (count($seoParams) ? '?' . http_build_query($seoParams) : '');
@endphp

<x-app-layout :title="$adCategory->title . $addParams" :description="$adCategory->description . $addParams" :canonical="$canonicalUrl">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __($adCategory->header) }}
            </h1>

            @php
                $sort = request()->sort;
                $user = Auth::user();
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'price_low_to_high' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->getName(),
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'price_low_to_high' ? null : 'price_low_to_high',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('Price: Low to High') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'price_high_to_low' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->getName(),
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'price_high_to_low' ? null : 'price_high_to_low',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('Price: High to Low') }}
                    </x-dropdown-link>
                </x-slot>
            </x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('ad.components.blurb')
        @include('ad.components.filter')

        <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader"
            x-data="{}" x-init="new InfiniteLoader({ endpoint: '{{ route('ads', request()->route()->originalParameters()) }}', data: {{ request()->collect() }}, page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }}, count: 15 });">
            @include('ad.components.list', ['owner' => false])
        </div>
    </div>
</x-app-layout>
