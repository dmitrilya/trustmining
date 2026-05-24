<section>
    <header class="mb-2">
        <div class="flex items-center justify-between">
            <h2 class="text-lg text-slate-950 dark:text-slate-50">
                {{ __('Spins history') }}
            </h2>

            <button aria-label="{{ __('TM Roulette') }}" @click="$dispatch('open-modal', 'roulette')"
                class="relative inline-flex items-center text-sm text-center text-slate-600 dark:text-slate-500 hover:text-slate-500 dark:hover:text-slate-400 focus:outline-none">
                <svg class="w-5 h-5" aria-hidden="true" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17 1L13 3.5L16.5 7L17 1Z" fill="currentColor" />
                    <path
                        d="M10 2C5.58 2 2 5.58 2 10C2 14.42 5.58 18 10 18C14.42 18 18 14.42 18 10C18 5.58 14.42 2 10 2ZM10 4C10.55 4 11 4.45 11 5V6.18C12.46 6.54 13.46 7.54 13.82 9H15C15.55 9 16 9.45 16 10C16 10.55 15.55 11 15 11H13.82C13.46 12.46 12.46 13.46 11 13.82V15C11 15.55 10.55 16 10 16C9.45 16 9 15.55 9 15V13.82C7.54 13.46 6.54 12.46 6.18 11H5C4.45 11 4 10.55 4 10C4 9.45 4.45 9 5 9H6.18C6.54 7.54 7.54 6.54 9 6.18V5C9 4.45 9.45 4 10 4ZM10 8C8.9 8 8 8.9 8 10C8 11.1 8.9 12 10 12C11.1 12 12 11.1 12 10C12 8.9 11.1 8 10 8Z"
                        fill="currentColor" />
                </svg>
            </button>
        </div>
    </header>

    <p class="text-sm text-slate-700 dark:text-slate-400 mb-6">
        {{ __('To activate your prizes, you need to log in through your Telegram account.') }}
    </p>

    @php
        $EXTRA_SPIN_NAME = config('settings.roulette.extra_spin_name');

        $allSpins = $user->rouletteSpins()->with('roulettePrize')->latest()->get();

        [$extraSpins, $regularPrizes] = $allSpins->partition(function ($spin) use ($EXTRA_SPIN_NAME) {
            return $spin->roulettePrize->name === $EXTRA_SPIN_NAME;
        });

        $latestExtraSpin = $extraSpins->first();

        $filteredSpins = collect();

        if ($latestExtraSpin) {
            $filteredSpins->push($latestExtraSpin);
        }

        $spinsForRender = $filteredSpins->merge($regularPrizes)->sortByDesc('created_at');
    @endphp

    @foreach ($spinsForRender as $spin)
        <div class="py-2 border-t border-slate-300 dark:border-slate-700">
            <div class="flex justify-between items-center mb-3">
                <div class="text-slate-800 dark:text-slate-200 font-bold">
                    {{ $spin->roulettePrize->name }}
                </div>

                @if ($spin->roulettePrize->name != $EXTRA_SPIN_NAME)
                    <a href="{{ $spin->roulettePrize->href }}">
                        <x-primary-button>{{ __('Take') }}</x-primary-button>
                    </a>
                @endif
            </div>

            <div class="text-xs text-slate-600 dark:text-slate-400">
                {{ $spin->roulettePrize->caption }}
            </div>
        </div>
    @endforeach
</section>
