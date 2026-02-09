@php
    $model = request()->model
        ? \App\Models\Database\AsicModel::where('name', str_replace('_', ' ', request()->model))->first('name')
        : null;
@endphp

<x-app-layout :title="$adCategory->title . ($model ? ' - модель ' . $model->name : '')" :description="$adCategory->description . ($model ? ' - модель ' . $model->name : '')">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __($adCategory->header) }}
            </h1>

            @php
                $sort = request()->sort;
                user = Auth::user();
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'price_low_to_high' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->action['as'],
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'price_low_to_high' ? null : 'price_low_to_high',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('Price: Low to High') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'price_high_to_low' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->action['as'],
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

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('ad.components.blurb')

        @include('ad.components.list', ['owner' => false])
    </div>
</x-app-layout>
