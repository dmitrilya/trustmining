<div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4">
    <h2
        class="mb-3 sm:mb-5 xs:text-lg sm:text-xl text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-bold">
        {{ __('Network difficulty') }} BTC
    </h2>

    <div class="text-xs xs:text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-400 mb-3 sm:mb-4 lg:mb-6">
        {{ $difficultyData['difficulty'] }}
    </div>

    <a class="text-xxs xs:text-xs text-indigo-500 hover:text-indigo-600 underline mt-2 sm:mt-3"
        target="_blank"
        href="{{ route('insight.article.show', ['channel' => $difficultyData['article']['channel_slug'], 'article' => $difficultyData['article']['id'] . '-' . $difficultyData['article']['slug']]) }}">
        {{ __('What is network difficulty?') }}
    </a>

    <a href="{{ route('metrics.network.difficulty', ['coin' => $difficultyData['coin']]) }}" target="_blank">
        <x-primary-button class="flex items-center mt-2 sm:mt-3">
            <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
            </svg>

            {{ __('Get forecast') }}
        </x-primary-button>
    </a>
</div>
