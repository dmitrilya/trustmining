<x-app-layout :title="isset($adCategory) ? $adCategory->title : 'Объявления'" :description="isset($adCategory) ? $adCategory->description : 'Объявления о продаже товаров и предоставлении услуг из сферы майнинга'">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($adCategory) ? __($adCategory->header) : __('Ads') }}
            </h2>

            @php
                $sort = request()->sort;
            @endphp

            <x-header-filters>
                <x-slot name="sort">
                    @if (($user = Auth::user()) && ($user->tariff || $user->role_id != 2))
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
                    @else
                        <div class="px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-900 transition duration-150 ease-in-out"
                            @click.prevent="$dispatch('open-modal', 'need-subscription')">{{ __('Price: Low to High') }}
                        </div>
                        <div class="px-4 py-2 text-left text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-zinc-900 transition duration-150 ease-in-out"
                            @click.prevent="$dispatch('open-modal', 'need-subscription')">{{ __('Price: High to Low') }}
                        </div>
                    @endif
                </x-slot>
            </x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('ad.components.blurb')

        @include('ad.components.list', ['owner' => false])
    </div>
</x-app-layout>
