<div class="space-y-2">
    <div class="relative h-2 bg-slate-200 dark:bg-slate-800 rounded-full">
        @php
            $minScore = $factor['min'] ?? ($factor['penalty'] ?? 0);
            $maxScore = $factor['max'] ?? 0;
            $score = $factor['score'] ?? 0;

            $range = $maxScore - $minScore;

            $position = $range > 0 ? (($score - $minScore) / $range) * 100 : 0;
            $position = max(0, min(100, $position));

            $clipRight = 100 - $position;
        @endphp

        <div class="absolute inset-0 opacity-25 rounded-full" style="background: linear-gradient(to right, #f43f5e, #f59e0b 50%, #10b981);"></div>

        <div class="absolute inset-0 rounded-full"
            style="background: linear-gradient(to right, #f43f5e, #f59e0b 50%, #10b981);clip-path: inset(0 {{ $clipRight }}% 0 0);">
        </div>

        <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-white dark:bg-slate-200 border-2 border-slate-700 dark:border-slate-300 shadow-sm z-10"
            style="left: calc({{ $position }}% - 6px);"></div>
    </div>

    @if (!empty($factor['components']))
        <details class="group/details">
            <summary class="cursor-pointer select-none text-xs text-indigo-500 hover:text-indigo-600 transition">
                <span class="group-open/details:hidden">
                    {{ __('Details') }}
                </span>

                <span class="hidden group-open/details:inline">
                    {{ __('Toggle hidden') }}
                </span>
            </summary>

            <div class="mt-2 pl-3 border-l border-slate-300 dark:border-slate-700 space-y-2">
                @foreach ($factor['components'] as $component)
                    <div class="flex items-center justify-between gap-3">

                        <div class="min-w-0">
                            <div class="text-xs text-slate-800 dark:text-slate-200">
                                {{ __('trustfactor.factors.' . $factor['name'] . '.components.' . $component['name'] . '.title') }}
                            </div>
                        </div>

                        <div class="shrink-0">
                            @if ($factor['type'] === 'threshold_group')
                                <div class="text-xxs font-mono text-slate-600 dark:text-slate-400">
                                    {{ $component['display'] ?? '—' }}
                                </div>
                            @else
                                <div
                                    class="text-xxs font-mono w-6 flex justify-center py-0.5 rounded
                                        {{ $component['score'] > 0
                                            ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                                            : ($component['score'] < 0
                                                ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400'
                                                : 'bg-slate-500/10 text-slate-500') }}">
                                    {{ $component['score'] > 0 ? '+' : '' }}{{ $component['score'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </details>
    @endif
</div>
