<details class="group/details">
    <summary class="cursor-pointer select-none text-xs text-indigo-500 hover:text-indigo-600 transition">
        <span class="group-open/details:hidden">{{ __('Details') }}</span>

        <span class="hidden group-open/details:inline">{{ __('Toggle hidden') }}</span>
    </summary>

    <div class="mt-2 pl-3 border-l border-slate-300 dark:border-slate-700 space-y-2">
        @foreach ($factor['components'] as $component)
            <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <div class="text-xs text-slate-800 dark:text-slate-200">
                        {{ __('trustfactor.factors.' . $factor['name'] . '.components.' . $component['name'] . '.title') }}
                    </div>
                </div>

                <div
                    class="shrink-0 text-xxs font-mono w-6 flex justify-center py-0.5 rounded
                                                    {{ ($component['value'] && $component['max'] > 0) || (!$component['value'] && $component['max'] == 0)
                                                        ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                                                        : 'bg-rose-500/10 text-rose-600 dark:text-rose-400' }}">
                    {{ $component['value'] && $component['max'] > 0 ? '+' : '' }}
                    @if ($component['value'])
                        {{ $component['score'] }}
                    @elseif ($component['max'] == 0)
                        <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @else
                        <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</details>
