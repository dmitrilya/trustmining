<div class="bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4">
    <h2
        class="mb-3 sm:mb-5 xs:text-lg sm:text-xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
        {{ __('Network difficulty') }} BTC
    </h2>

    @php
        $coin = App\Models\Database\Coin::where('abbreviation', 'BTC')->first();
        $guide = App\Models\Blog\Guide::find(10000001);
    @endphp

    <div class="text-xs xs:text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-300 mb-3 sm:mb-4 lg:mb-6">
        {{ number_format($coin->networkDifficulties()->latest()->first()->difficulty) }}
    </div>

    @if ($guide)
        <a class="text-xxs xs:text-xs text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-600 underline mt-2 sm:mt-3"
            target="_blank"
            href="{{ route('guide', ['user' => $guide->user->id, 'guide' => $guide->id . '-' . strtolower(str_replace(' ', '-', $guide->title))]) }}">
            {{ __('What is network difficulty?') }}
        </a>
    @endif

    <a href="{{ route('metrics.network.difficulty', ['coin' => $coin->name]) }}" target="_blank">
        <x-primary-button class="flex items-center mt-2 sm:mt-3">
            <svg class="size-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 14v4.833A1.166 1.166 0 0 1 16.833 20H5.167A1.167 1.167 0 0 1 4 18.833V7.167A1.166 1.166 0 0 1 5.167 6h4.618m4.447-2H20v5.768m-7.889 2.121 7.778-7.778" />
            </svg>

            {{ __('Get forecast') }}
        </x-primary-button>
    </a>
</div>
