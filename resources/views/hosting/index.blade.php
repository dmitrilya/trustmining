<x-app-layout title="Майнинг отель: разместить оборудование, проверенные хостинги"
    description="Найти объявления о майнинг фермах на сайте TrustMining">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
                {{ __('Hostings') }}
            </h1>

            @php
                $sort = request()->sort;
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    @if (($user = Auth::user()) && $user->tariff)
                        <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'price_low_to_high' ? 'true' : 'false' }} }" :href="route(
                            request()->route()->action['as'],
                            array_merge(request()->route()->originalParameters(), [
                                'sort' => $sort && $sort == 'price_low_to_high' ? null : 'price_low_to_high',
                                http_build_query(request()->except('sort')),
                            ]),
                        )">
                            {{ __('Price: Low to High') }}
                        </x-dropdown-link>

                        <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'price_high_to_low' ? 'true' : 'false' }} }" :href="route(
                            request()->route()->action['as'],
                            array_merge(request()->route()->originalParameters(), [
                                'sort' => $sort && $sort == 'price_high_to_low' ? null : 'price_high_to_low',
                                http_build_query(request()->except('sort')),
                            ]),
                        )">
                            {{ __('Price: High to Low') }}
                        </x-dropdown-link>
                    @else
                        <div class="px-4 py-2 text-left text-sm leading-5 text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-900 transition duration-150 ease-in-out"
                            @click.prevent="$dispatch('open-modal', 'need-subscription')">{{ __('Price: Low to High') }}
                        </div>
                        <div class="px-4 py-2 text-left text-sm leading-5 text-slate-800 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-900 transition duration-150 ease-in-out"
                            @click.prevent="$dispatch('open-modal', 'need-subscription')">{{ __('Price: High to Low') }}
                        </div>
                    @endif
                </x-slot>
            </x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('hosting.components.blurb')

        <x-filter>@include('hosting.components.filter')</x-filter>

        <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
            @php
                $auth = Auth::user();
            @endphp

            @include('hosting.components.list')
        </div>
    </div>
</x-app-layout>
