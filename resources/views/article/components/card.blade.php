<div class="flex sm:flex-col w-full h-full">
    <a href="{{ route('article', ['article' => $article->id]) }}"
        class="h-full sm:max-h-32 w-1/3 sm:w-full rounded-lg overflow-hidden flex justify-center items-center">
        <img class="h-full sm:h-max max-w-none sm:w-full"
            src="{{ Storage::url('public/articles/' . $article->id . '.webp') }}" alt="{{ $article->title }}" />
    </a>
    <div class="flex flex-col w-2/3 sm:w-full h-full justify-between py-2 sm:py-3 px-3 sm:px-4">
        <div>
            <p class="date-transform text-xxs sm:text-xs font-normal text-gray-400" data-type="date"
                data-date="{{ $article->created_at }}"></p>
            <a href="{{ route('article', ['article' => $article->id]) }}">
                <h5
                    class="my-1 sm:my-2 text-sm sm:text-lg font-bold !leading-6 tracking-tight text-gray-900 dark:text-white">
                    {{ $article->title }}</h5>
            </a>
            <p class="text-xs sm:text-sm font-normal text-gray-700 dark:text-gray-400">
                {{ $article->subtitle }}</p>
        </div>
        <a class="block ml-auto sm:w-full mt-1 sm:mt-4"
            href="{{ route('article', ['article' => $article->url_title]) }}">
            <x-secondary-button class="w-full justify-center">{{ __('Details') }}</x-secondary-button>
        </a>
    </div>
</div>
