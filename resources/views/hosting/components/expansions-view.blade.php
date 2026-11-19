<div class="w-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow rounded-xl p-2 sm:p-4 space-y-4">
    <div class="flex items-center gap-2">
        <div class="p-1.5 sm:p-2 bg-indigo-500/10 border border-indigo-600 text-indigo-500 rounded-lg">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <h4 class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-200">
                {{ __('Expansion prospects') }}
            </h4>
            <p class="text-xxs xs:text-xs text-slate-600 dark:text-slate-400">
                {{ __('Planned capacity upgrades') }}
            </p>
        </div>
    </div>

    @php
        $expansions = collect($hosting->hostingExpansions()->where('planned_at', '>', now())->get() ?? [])->sortBy('planned_at');
        $months = __('time.month_names');
    @endphp

    @if ($expansions->isEmpty())
        <div class="text-center py-4 text-xs text-slate-500 italic">
            {{ __('No expansion plans specified') }}
        </div>
    @else
        <div class="space-y-2">
            @foreach ($expansions as $expansion)
                @php
                    $date = \Carbon\Carbon::parse($expansion['planned_at']);
                    $monthKey = strtolower($date->format('F'));
                    $monthName = $months[$monthKey] ?? $date->format('M');
                    $year = $date->format('Y');
                @endphp

                <div
                    class="flex items-center justify-between bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 p-2 rounded-xl">
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">
                            {{ $monthName }}
                        </span>
                        <span class="text-xxs text-slate-500 font-medium">
                            {{ $year }} {{ __('г.') }}
                        </span>
                    </div>

                    <div class="text-right">
                        <span class="text-xs xs:text-sm font-bold text-indigo-600 dark:text-indigo-400">
                            +{{ number_format($expansion['capacity'], 0, '.', ' ') }} <span class="text-xxs font-normal text-slate-500">кВт</span>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
