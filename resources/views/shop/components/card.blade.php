<div
    class="relative sm:max-w-md p-2 h-full sm:px-4 sm:py-3 bg-white shadow-md overflow-hidden rounded-lg flex flex-col justify-between">
    <div>
        <div
            class="w-full aspect-[4/3] overflow-hidden rounded-lg overflow-hidden flex justify-center items-center @if (!$shop->company) bg-gray-200 dark:bg-gray-600 @endif">
            @if ($shop->company)
                <img class="w-full" src="{{ Storage::url($shop->company->logo) }}" alt="{{ $shop->url_name }}">
            @else
                <p class="text-sm xs:text-lg text-white dark:text-gray-800 font-bold">{{ __('No logo') }}</p>
            @endif
        </div>

        <div class="mt-2 sm:mt-4 text-sm sm:text-base text-gray-900 dark:text-white font-bold">{{ $shop->name }}</div>

        <div class="text-xs text-gray-400">
            {{ $shop->company && !$shop->company->moderation ? __('Company') : __('Person') }}
        </div>

        <div class="flex items-center mt-2 sm:mt-4" x-data="{ momentRating: {{ $shop->moderatedReviews->count() ? $shop->moderatedReviews->avg_rating : 0 }} }">
            <x-rating sm="true"></x-rating>

            <p class="ml-3 text-xxs xs:text-xs sm:text-sm text-indigo-600 hover:text-indigo-500">
                {{ $shop->moderatedReviews->count() }} {{ __('reviews') }}
            </p>
        </div>

        <p class="mt-4 sm:mt-5 text-xxs sm:text-sm text-gray-400">
            {{ __('Trust Factor') }}: <span class="text-gray-600">{{ $shop->tf }}</span>
        </p>

        <p class="mt-1 sm:mt-2 text-xxs sm:text-sm text-gray-400">
            {{ __('Number of offices') }}: <span class="text-gray-600">{{ $shop->offices_count }}</span>
        </p>
    </div>

    <a class="block w-full mt-3 sm:mt-4 lg:mt-5" href="{{ route('company', ['user' => $shop->url_name]) }}">
        <x-primary-button class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
    </a>
</div>
