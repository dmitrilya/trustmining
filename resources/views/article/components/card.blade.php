<div
    class="relative sm:max-w-md h-full bg-white dark:bg-zinc-900 shadow-md dark:shadow-zinc-800 overflow-hidden rounded-lg flex flex-col justify-between">
    <div>
        <div class="w-full aspect-[4/3] overflow-hidden rounded-lg flex justify-center items-center">
            <img class="w-full" src="{{ Storage::url('public/articles/' . $article->id . '.webp') }}" alt="{{ $article->title }}" />
        </div>
        <div class="px-2 pt-2 md:px-3 md:pt-3">
            <h3
                class="my-1 sm:my-2 text-sm sm:text-lg font-bold !leading-6 tracking-tight text-gray-950 dark:text-gray-50">
                {{ $article->title }}</h3>
            <p class="text-xs sm:text-sm text-gray-800 dark:text-gray-300">
                {{ $article->subtitle }}</p>
        </div>
    </div>
    <div class="p-2 md:p-3">
        <div class="flex items-center justify-between">
            <p class="date-transform text-xxs sm:text-xs text-gray-500 dark:text-gray-400" data-type="date"
                data-date="{{ $article->created_at }}"></p>

            <div class="flex items-center">
                <svg class="w-4 h-4 text-gray-700 dark:text-gray-50" aria-hidden="true" width="24" height="24"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                        clip-rule="evenodd" />
                </svg>

                <p class="text-xxs sm:text-xs text-gray-500 dark:text-gray-400 ml-2">{{ $article->views()->count() }}</p>
            </div>
        </div>
        <a class="block ml-auto sm:w-full mt-1 sm:mt-4" href="{{ route('article', ['article' => $article->id . '-' . mb_strtolower(str_replace(' ', '-', $article->title))]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Details') }}</x-secondary-button>
        </a>
    </div>
</div>
