<div class="w-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow rounded-xl p-2 sm:p-4 space-y-4">
    <div class="flex items-start justify-between">
        <div class="flex items-center gap-2">
            <div class="p-1.5 sm:p-2 bg-indigo-500/10 border border-indigo-600 text-indigo-500 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h4 class="text-sm font-bold text-slate-800 dark:text-slate-200">
                {{ __('Power Status') }}
            </h4>
        </div>
        <span class="text-xxs bg-indigo-500/10 border border-indigo-600 text-indigo-500 px-2 py-1 rounded-lg"
            title="{{ __('Last updated time') }}">
            {{ $hosting->hostingCapacity?->created_at?->diffForHumans() }}
        </span>
    </div>

    @php
        $total = $hosting->hostingCapacity?->total ?? 0;
        $occupied = $hosting->hostingCapacity?->occupied ?? 0;
        $free = max(0, $total - $occupied);

        $percentage = $total > 0 ? min(100, round(($occupied / $total) * 100)) : 0;
    @endphp

    <div class="grid grid-cols-3 gap-2 text-center">
        <div class="p-2 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl">
            <div class="block text-xxs xs:text-xs uppercase tracking-wider text-slate-500 mb-1">
                {{ __('Total') }}
            </div>
            <div class="xs:text-lg sm:text-xl lg:text-2xl font-mono text-slate-800 dark:text-slate-200">
                {{ number_format($total / 1000, 0, '.', ' ') }} <span class="text-xs font-semibold text-slate-500">{{ __('MW') }}</span>
            </div>
        </div>

        <div class="p-2 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl">
            <div class="block text-xxs xs:text-xs uppercase tracking-wider text-slate-500 mb-1">
                {{ __('Occupied') }}
            </div>
            <div class="xs:text-lg sm:text-xl lg:text-2xl font-mono text-rose-600 dark:text-rose-400">
                {{ number_format($occupied / 1000, 0, '.', ' ') }} <span class="text-xs font-semibold text-slate-500">{{ __('MW') }}</span>
            </div>
        </div>

        <div class="p-2 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl">
            <div class="block text-xxs xs:text-xs uppercase tracking-wider text-slate-500 mb-1">
                {{ __('Free') }}
            </div>
            <div class="xs:text-lg sm:text-xl lg:text-2xl font-mono text-emerald-600 dark:text-emerald-400">
                {{ number_format($free / 1000, 0, '.', ' ') }} <span class="text-xs font-semibold text-slate-500">{{ __('MW') }}</span>
            </div>
        </div>
    </div>

    <div class="space-y-1.5">
        <div class="flex justify-between items-end text-xs">
            <span class="text-slate-500 font-medium">{{ __('Capacity load') }}</span>
            <span
                class="font-bold {{ $percentage >= 80 ? 'text-rose-600 dark:text-rose-400' : ($percentage >= 60 ? 'text-amber-600 dark:text-amber-400' : 'text-emerald-600 dark:text-emerald-400') }} text-sm">
                {{ $percentage }}%
            </span>
        </div>

        <div class="relative w-full h-1.5 bg-linear-to-r from-indigo-500 to-indigo-700 rounded-full overflow-hidden">
            <div class="absolute top-0 bottom-0 right-0 bg-white/80 dark:bg-slate-900/80 transition-all duration-500" style="width: {{ 100 - $percentage }}%">
            </div>
        </div>
    </div>
</div>
