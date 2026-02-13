@if (isset($adCategory) && !isset($shop))
    <x-filter>
        @include('ad.' . $adCategory->name . '.filter')

        <div class="relative mt-4" x-data="{ open: false, sugs: false }" @click.away="open = false">
            <div class="relative z-0 w-full group" @click="open = true">
                <input type="text" id="city" name="city" x-ref="search" placeholder=" "
                    value="{{ request()->get('city') ?? session('user_city') }}" autocomplete="off"
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
@endif

<fieldset aria-label="Choose a ad" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @if ($owner)
            <a href="{{ route('ad.create') }}"
                class="cursor-pointer bg-gray-100 dark:bg-zinc-800 group hover:bg-white dark:hover:bg-zinc-900 sm:max-w-md p-2 h-full sm:px-4 sm:py-3 shadow-md shadow-logo-color overflow-hidden rounded-lg flex justify-center items-center border-2 border-dashed border-gray-400 dark:border-zinc-700">
                <div class="flex flex-col justify-center items-center">
                    <svg class="w-[72px] h-[72px] text-gray-400 dark:text-gray-300" aria-hidden="true" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2"
                            d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                    </svg>

                    <div
                        class="font-semibold text-xl text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-gray-200 mt-2">
                        {{ __('Create') }}</div>
                </div>
            </a>
        @endif

        @foreach ($ads as $ad)
            @continue(!$owner && ($ad->moderation || $ad->hidden))

            @if (isset($shop))
                <template x-if="!ad_category_id || {{ $ad->ad_category_id }} == ad_category_id">
                    @include('ad.components.card')
                </template>
            @else
                @include('ad.components.card')
            @endif
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $ads->links() }}
</div>
