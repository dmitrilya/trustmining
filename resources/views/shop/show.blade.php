<x-app-layout title="Майнинговая компания {{ $user->name }}: купить ASIC майнер"
    description="Официальный представитель {{ $user->name }}: купите ASIC-майнеры Bitmain, Whatsminer и Canaan с гарантией от производителя. Большой выбор оборудования в наличии, низкие цены, быстрая доставка и профессиональная поддержка 24/7. Проверьте и заберите майнеры в наших офисах или закажите онлайн">
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="flex items-center mr-auto w-full max-w-max mr-4">
                <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ $user->name }}
                </h1>
            </div>

            @php
                $sort = request()->sort;
                $auth = Auth::user();
            @endphp

            <div class="flex justify-between items-center w-full mt-4 lg:mt-0">
                @include('shop.components.menu')

                <x-header-filters>
                    <x-slot name="sort">
                        @if ($auth && $auth->tariff)
                            <x-dropdown-link ::class="{ 'bg-gray-200': {{ $sort && $sort == 'price_low_to_high' ? 'true' : 'false' }} }" :href="route(
                                request()->route()->action['as'],
                                array_merge(request()->route()->originalParameters(), [
                                    'sort' => $sort && $sort == 'price_low_to_high' ? null : 'price_low_to_high',
                                    http_build_query(request()->except('sort')),
                                ]),
                            )">
                                {{ __('Price: Low to High') }}
                            </x-dropdown-link>

                            <x-dropdown-link ::class="{ 'bg-gray-200': {{ $sort && $sort == 'price_high_to_low' ? 'true' : 'false' }} }" :href="route(
                                request()->route()->action['as'],
                                array_merge(request()->route()->originalParameters(), [
                                    'sort' => $sort && $sort == 'price_high_to_low' ? null : 'price_high_to_low',
                                    http_build_query(request()->except('sort')),
                                ]),
                            )">
                                {{ __('Price: High to Low') }}
                            </x-dropdown-link>
                        @else
                            <div class="px-4 py-2 text-left text-sm leading-5 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-900 transition duration-150 ease-in-out"
                                @click.prevent="$dispatch('open-modal', 'need-subscription')">
                                {{ __('Price: Low to High') }}
                            </div>
                            <div class="px-4 py-2 text-left text-sm leading-5 text-gray-800 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-900 transition duration-150 ease-in-out"
                                @click.prevent="$dispatch('open-modal', 'need-subscription')">
                                {{ __('Price: High to Low') }}
                            </div>
                        @endif
                    </x-slot>
                </x-header-filters>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8" x-data="{ ad_category_id: null }">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            @foreach ($ads->pluck('adCategory')->unique() as $adCategory)
                <div @click="ad_category_id = ad_category_id == {{ $adCategory->id }} ? null : {{ $adCategory->id }}"
                    class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group hover:bg-indigo-200 dark:hover:bg-indigo-600 border hover:border-indigo-500 dark:hover:border-indigo-700 rounded-md"
                    :class="{
                        'border-indigo-500 bg-indigo-200 dark:bg-indigo-600 dark:border-indigo-700': ad_category_id ==
                            '{{ $adCategory->id }}',
                        'border-gray-300 dark:border-zinc-700': ad_category_id !=
                            '{{ $adCategory->id }}'
                    }">
                    <h5 class="font-semibold text-xxs sm:text-xs lg:text-sm group-hover:text-indigo-500 dark:group-hover:text-gray-100"
                        :class="{
                            'text-indigo-500 dark:text-gray-50': ad_category_id ==
                                '{{ $adCategory->id }}',
                            'text-gray-500 dark:text-gray-300': ad_category_id !=
                                '{{ $adCategory->id }}'
                        }">
                        {{ __($adCategory->header) }}
                    </h5>
                </div>
            @endforeach
        </div>

        <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @if ($auth && $auth->id == $user->id)
                <a href="{{ route('ad.create') }}"
                    class="cursor-pointer bg-gray-100 dark:bg-zinc-800 group hover:bg-white dark:hover:bg-zinc-900 sm:max-w-md p-2 h-full sm:px-4 sm:py-3 shadow-md shadow-logo-color overflow-hidden rounded-lg flex justify-center items-center border-2 border-dashed border-gray-400 dark:border-zinc-700">
                    <div class="flex flex-col justify-center items-center">
                        <svg class="w-[72px] h-[72px] text-gray-400 dark:text-gray-300" aria-hidden="true"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                                d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>

                        <div
                            class="font-semibold text-xl text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 mt-2">
                            {{ __('Create') }}</div>
                    </div>
                </a>
            @endif

            @include('ad.components.list', ['owner' => $auth && $auth->id == $user->id, 'shop' => true])
        </div>
    </div>
</x-app-layout>
