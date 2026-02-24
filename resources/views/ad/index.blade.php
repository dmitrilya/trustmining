@php
    $model = request()->model
        ? \App\Models\Database\AsicModel::where('name', str_replace('_', ' ', request()->model))->first('name')
        : null;
@endphp

<x-app-layout :title="$adCategory->title . ($model ? ' - модель ' . $model->name : '')" :description="$adCategory->description . ($model ? ' - модель ' . $model->name : '')">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __($adCategory->header) }}
            </h1>

            @php
                $sort = request()->sort;
                $user = Auth::user();
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

        <x-filter>
            @include('ad.' . $adCategory->name . '.filter')

            <x-filter-filter type="checkbox" :name="__('VAT')" :items="collect([
                ['name' => 'Price including VAT', 'url_name' => 'with_vat'],
                ['name' => 'Price without VAT', 'url_name' => 'without_vat'],
            ])" field="vat"></x-filter-filter>

            <div class="relative mt-4" x-data="{ open: false, sugs: false }" @click.away="open = false">
                <div class="relative z-0 w-full group" @click="open = true">
                    <input type="text" id="city" name="city" x-ref="search" placeholder=" "
                        value="{{ request()->get('city') }}" autocomplete="off"
                        @input.debounce.1000ms="sugs = dadataSuggs($el.value, $refs.suggestionList, open, 'city')"
                        class="block py-2.5 px-0 w-full text-sm text-gray-950 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-zinc-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                    <label for="city"
                        class="absolute text-sm text-gray-600 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('First from the city') }}
                    </label>
                </div>

                <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                    class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                </ul>
            </div>

            @if (in_array(request()->route()->action['as'], ['company']) &&
                    ($user = Auth::user()) &&
                    $user->id == request()->user->id)
                <x-filter-filter type="radio" :name="__('Display')" :items="collect([
                    ['name' => 'View all', 'url_name' => ''],
                    ['name' => 'Active', 'url_name' => 'active'],
                    ['name' => 'Is under moderation', 'url_name' => 'moderation'],
                    ['name' => 'Rejected', 'url_name' => 'rejected'],
                    ['name' => 'Hidden', 'url_name' => 'hidden'],
                ])" field="display"></x-filter-filter>
            @endif
        </x-filter>

        <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader" x-data="{}"
            x-init="new InfiniteLoader({ endpoint: '{{ route('ads', ['adCategory' => $adCategory->name]) }}', page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }}, count: 15 });">
            @include('ad.components.list', ['owner' => false])
        </div>
    </div>
</x-app-layout>
