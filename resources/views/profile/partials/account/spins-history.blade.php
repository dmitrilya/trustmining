<x-profile.section h="Spins history" p="To activate your prizes, you need to log in through your Telegram account">
    <x-slot name="i">
        @include('roulette.roulette-icon')
    </x-slot>

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
                        <x-buttons.primary-button>{{ __('Take') }}</x-buttons.primary-button>
                    </a>
                @endif
            </div>

            <div class="text-xs text-slate-600 dark:text-slate-400">
                {{ $spin->roulettePrize->caption }}
            </div>
        </div>
    @endforeach
</x-profile.section>
