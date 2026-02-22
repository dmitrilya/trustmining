<div
    class="relative sm:max-w-md p-2 h-full sm:px-4 sm:py-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color overflow-hidden rounded-lg flex flex-col justify-between">
    <div>
        <div
            class="w-full aspect-[4/3] overflow-hidden rounded-lg overflow-hidden flex justify-center items-center @if (!$shop->company) bg-gray-200 dark:bg-zinc-700 @endif">
            <a class="block w-full" href="{{ route('company', ['user' => $shop->url_name]) }}">
                @if ($shop->company?->bg_logo)
                    @php
                        $preview = explode('.', $shop->company->bg_logo);
                        $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                        $previewxs = $baseName . '_188' . '.' . $preview[1];
                    @endphp

                    <picture>
                        <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                        <img class="w-full object-cover" src="{{ Storage::url($shop->company->bg_logo) }}" alt="{{ $shop->name }} preview">
                    </picture>
                @else
                    <p class="text-sm xs:text-lg text-white dark:text-gray-800 font-bold">{{ __('No logo') }}</p>
                @endif
            </a>
        </div>

        <div class="mt-2 sm:mt-4 text-sm sm:text-base text-gray-950 dark:text-gray-50 font-bold">{{ $shop->name }}
        </div>

        <div class="text-xs text-gray-500 dark:text-gray-400">
            {{ $shop->company && !$shop->company->moderation ? __($shop->company->card['type']) : __('Person') }}
        </div>

        <div class="flex items-center mt-2 sm:mt-4" x-data="{ momentRating: {{ $shop->moderatedReviews->count() ? $shop->moderatedReviews->avg('rating') : 0 }} }">
            <x-rating sm="true"></x-rating>

            <p class="ml-3 text-xxs xs:text-xs sm:text-sm text-indigo-600 hover:text-indigo-500">
                {{ $shop->moderatedReviews->count() }} {{ __('reviews') }}
            </p>
        </div>

        <div class="flex items-center mt-4 sm:mt-5">
            <div
                class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-gray-300 dark:border-zinc-700 {{ $shop->tf > config('trustfactor.yellow') ? ($shop->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
            </div>
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500">Trust Factor</p>
        </div>

        <p class="mt-1 sm:mt-2 text-xxs sm:text-sm text-gray-500 dark:text-gray-400">
            {{ __('Number of offices') }}: <span
                class="text-gray-700 dark:text-gray-300">{{ $shop->offices_count }}</span>
        </p>
    </div>

    <a class="block w-full mt-3 sm:mt-4 lg:mt-5" href="{{ route('company', ['user' => $shop->url_name]) }}">
        <x-primary-button class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
    </a>
</div>
