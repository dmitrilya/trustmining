<x-app-layout title="Майнинговые компании: рейтинг, отзывы" description="Рейтинг лучших майнинговых компаний России и мира. Актуальные отзывы реальных клиентов о надежности поставщиков оборудования, хостинге и обслуживании. Сравните компании по ценам, услугам и репутации, чтобы выбрать проверенного партнера">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Companies') }} @if (request()->get('city')){{ __('in the city') }} "{{ request()->get('city') }}" @endif
            </h2>

            @php
                $sort = request()->sort;
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'tf_high_to_low' ? 'true' : 'false' }} }" :href="route(
                        request()->route()->action['as'],
                        array_merge(request()->route()->originalParameters(), [
                            'sort' => $sort && $sort == 'tf_high_to_low' ? null : 'tf_high_to_low',
                            http_build_query(request()->except('sort')),
                        ]),
                    )">
                        {{ __('TF: High to Low') }}
                    </x-dropdown-link>

                    <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'tf_low_to_high' ? 'true' : 'false' }} }" :href="route(
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

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('shop.components.list')
    </div>
</x-app-layout>
