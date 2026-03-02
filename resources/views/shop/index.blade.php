<x-app-layout title="Майнинговые компании: рейтинг, отзывы" description="Рейтинг лучших майнинговых компаний России и мира. Актуальные отзывы реальных клиентов о надежности поставщиков оборудования, хостинге и обслуживании. Сравните компании по ценам, услугам и репутации, чтобы выбрать проверенного партнера">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
                {{ __('Companies') }} @if (request()->get('city')){{ __('in the city') }} "{{ request()->get('city') }}" @endif
            </h1>

            @php
                $sort = request()->sort;
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'tf_high_to_low' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->action['as'],
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'tf_high_to_low' ? null : 'tf_high_to_low',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('TF: High to Low') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'tf_low_to_high' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->action['as'],
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'tf_low_to_high' ? null : 'tf_low_to_high',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('TF: Low to High') }}
                    </x-dropdown-link>
                </x-slot>
            </x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('shop.components.list')
    </div>
</x-app-layout>
