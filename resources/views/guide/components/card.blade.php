<div class="flex sm:flex-col w-full h-full">
    <a href="{{ route('guide', ['guide' => $guide->id]) }}"
        class="h-full sm:max-h-32 w-1/3 sm:w-full rounded-lg overflow-hidden flex justify-center items-center">
        <img class="h-full sm:h-max max-w-none sm:w-full"
            src="{{ Storage::url('public/guides/' . $guide->id . '.webp') }}" alt="{{ $guide->title }}" />
    </a>
    <div class="flex flex-col w-2/3 sm:w-full h-full justify-between py-2 sm:py-3 px-3 sm:px-4">
        <div>
            <div class="flex items-center justify-between">
                <p class="date-transform text-xxs sm:text-xs font-normal text-gray-400" data-type="date"
                    data-date="{{ $guide->created_at }}"></p>

                <div class="flex items-center">
                    <svg class="w-4 h-4 text-gray-600 dark:text-white" aria-hidden="true" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <p class="text-xxs sm:text-xs font-normal text-gray-400 ml-2">{{ $guide->views()->count() }}</p>
                </div>
            </div>
            <a href="{{ route('guide', ['guide' => $guide->id]) }}">
                <h5
                    class="my-1 sm:my-2 text-sm sm:text-lg font-bold !leading-6 tracking-tight text-gray-900 dark:text-white">
                    {{ $guide->title }}</h5>
            </a>
            <p class="text-xs sm:text-sm font-normal text-gray-700 dark:text-gray-400">
                {{ $guide->subtitle }}</p>
        </div>
        <a class="block ml-auto sm:w-full mt-1 sm:mt-4"
            href="{{ route('guide', ['guide' => $guide->url_title]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Details') }}</x-secondary-button>
        </a>
    </div>
</div>
