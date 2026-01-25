<x-app-layout title="Майнинговая компания {{ $user->name }}: купить ASIC майнер" description="Официальный представитель {{ $user->name }}: купите ASIC-майнеры Bitmain, Whatsminer и Canaan с гарантией от производителя. Большой выбор оборудования в наличии, низкие цены, быстрая доставка и профессиональная поддержка 24/7. Проверьте и заберите майнеры в наших офисах или закажите онлайн">
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="flex items-center mr-auto w-full max-w-max mr-4">
                <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
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

        @include('ad.components.list', ['owner' => $auth && $auth->id == $user->id, 'shop' => true])
    </div>
</x-app-layout>
