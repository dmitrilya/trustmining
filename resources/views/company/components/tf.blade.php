<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 sm:gap-6">
        <div class="max-w-lg">
            <h2 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200">{{ __('Company reliability analysis') }}</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                {{ __('The criteria and their strictness depend on the main activity of the company and the presence of certain announcements') }}
            </p>
        </div>
        <div
            class="w-full sm:w-fit flex flex-col items-center text-xs px-4 py-2 rounded-xl border bg-indigo-50 dark:bg-indigo-950/40 border-indigo-600 text-emerald-600 dark:text-emerald-400">
            <div class="whitespace-nowrap text-slate-600 dark:text-slate-400 mb-1">{{ __('Main direction') }}</div>
            <div class="whitespace-nowrap text-indigo-500 uppercase">{{ __('trustfactor.directions.' . $tfData['direction']) }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4">
        @foreach ($tfData['factors'] as $factor)
            <div class="p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 flex flex-col justify-between">
                <div class="flex justify-between items-start gap-4 {{ $factor['type'] === 'threshold' ? 'mb-6' : 'mb-4' }}">
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-wide">
                            {{ __('trustfactor.factors.' . $factor['name'] . '.title') }}
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                            {{ __('trustfactor.factors.' . $factor['name'] . '.' . ($factor['type'] === 'list' && !$factor['value'] ? 'none' : 'description')) }}</span>
                        </p>
                    </div>

                    <div class="flex flex-col items-end">
                        @if ($factor['type'] === 'threshold' || $factor['type'] === 'group' || $factor['type'] === 'list')
                            <span
                                class="whitespace-nowrap text-xs px-2 py-0.5 rounded-full font-mono
                                {{ $factor['score'] > 0 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($factor['score'] < 0 ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400') }}">
                                {{ $factor['score'] > 0 ? '+' : '' }}{{ $factor['score'] }} pts
                            </span>
                        @endif

                        @if ($factor['type'] === 'boolean')
                            @if ($factor['value'] && $factor['bonus'] > 0)
                                <span class="whitespace-nowrap text-xxs text-emerald-600 dark:text-emerald-400 mt-1">Бонус получен</span>
                            @elseif(!$factor['value'] && $factor['penalty'] < 0)
                                <span class="whitespace-nowrap text-xxs text-rose-600 dark:text-rose-400 mt-1">Применен штраф</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div>
                    @if ($factor['type'] === 'threshold' || $factor['type'] === 'threshold_reverse')
                        <div class="space-y-1.5">
                            <div class="relative w-full h-2">
                                @php
                                    $sortedThresholds = $factor['thresholds'];
                                    if ($factor['type'] === 'threshold_reverse') {
                                        arsort($sortedThresholds);
                                    } else {
                                        asort($sortedThresholds);
                                    }

                                    $thresholdKeys = array_keys($sortedThresholds);

                                    $matchedIndex = array_search($factor['matched_threshold'], $thresholdKeys);
                                @endphp

                                <div class="w-full h-full flex">
                                    @foreach ($thresholdKeys as $i => $threshold)
                                        @php
                                            $count = count($thresholdKeys);
                                            $segmentWidth = 100 / $count;

                                            $gradientStart = $i * $segmentWidth;
                                            $gradientEnd = ($i + 1) * $segmentWidth;

                                            $isActive = $i === $matchedIndex;
                                        @endphp

                                        <div class="relative h-full {{ $loop->first ? 'rounded-l-full border-r' : ($loop->last ? 'rounded-r-full border-l' : 'border-x') }} border-slate-300 transition-opacity duration-300 {{ !$isActive ? 'opacity-20 select-none pointer-events-none' : 'opacity-100 z-10' }}"
                                            style="
                                                    width: {{ $segmentWidth }}%; 
                                                    background: linear-gradient(to right, var(--tw-gradient-stops));
                                                    --tw-gradient-from: #f43f5e var(--tw-gradient-from-position, 0%);
                                                    --tw-gradient-to: #10b981 var(--tw-gradient-to-position, 100%);
                                                    --tw-gradient-stops: var(--tw-gradient-from), #f59e0b {{ 50 }}%, var(--tw-gradient-to);
                                                    background-size: {{ $count * 100 }}% 100%;
                                                    background-position: -{{ $i * 100 }}% 0;
                                                ">
                                            @if ($isActive)
                                                <div class="absolute -top-5 left-1/2 -translate-x-1/2 text-xs font-mono text-slate-600 dark:text-slate-400">
                                                    {{ $factor['value'] }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex justify-between text-xxs font-mono text-slate-500 px-0.5">
                                <span>{{ $thresholdKeys[0] }}</span>
                                <span>{{ end($thresholdKeys) }}</span>
                            </div>
                        </div>
                    @elseif ($factor['type'] === 'group')
                        <div class="space-y-2">
                            <div class="relative h-2 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-800">
                                @php
                                    $max = max(abs($factor['max'] ?? 0), abs($factor['penalty'] ?? 0), 1);
                                    $score = $factor['score'] ?? 0;

                                    $minScore = $factor['penalty'] ?? 0;
                                    $maxScore = $factor['max'] ?? 0;

                                    $range = $maxScore - $minScore;

                                    $position = $range > 0 ? (($score - $minScore) / $range) * 100 : 0;

                                    $position = max(0, min(100, $position));
                                @endphp

                                <div class="absolute inset-0" style="background: linear-gradient(to right, #f43f5e, #f59e0b 50%, #10b981);"></div>

                                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-white dark:bg-slate-200 border-2 border-slate-700 dark:border-slate-300 shadow"
                                    style="left: calc({{ $position }}% - 6px);"></div>
                            </div>

                            @if (!empty($factor['components']))
                                <details class="group/details">
                                    <summary class="cursor-pointer select-none text-xs text-indigo-500 hover:text-indigo-600 transition">
                                        <span class="group-open/details:hidden">
                                            {{ __('Details') }}
                                        </span>

                                        <span class="hidden group-open/details:inline">
                                            {{ __('Скрыть подробности') }}
                                        </span>
                                    </summary>

                                    <div class="mt-2 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-2">
                                        @foreach ($factor['components'] as $component)
                                            <div class="flex items-center justify-between gap-3">

                                                <div class="min-w-0">
                                                    <div class="text-xs text-slate-700 dark:text-slate-300">
                                                        {{ __('trustfactor.factors.' . $factor['name'] . '.components.' . $component['name'] . '.title') }}
                                                    </div>
                                                </div>

                                                <div class="shrink-0">
                                                    @if ($component['type'] === 'threshold')
                                                        <span
                                                            class="text-xxs font-mono px-1.5 py-0.5 rounded
                                                                {{ $component['score'] > 0
                                                                    ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                                                                    : ($component['score'] < 0
                                                                        ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400'
                                                                        : 'bg-slate-500/10 text-slate-500') }}">
                                                            {{ $component['score'] > 0 ? '+' : '' }}{{ $component['score'] }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="text-xxs font-mono px-1.5 py-0.5 rounded
                                                                {{ $component['score'] > 0
                                                                    ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'
                                                                    : ($component['score'] < 0
                                                                        ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400'
                                                                        : 'bg-slate-500/10 text-slate-500') }}">
                                                            {{ $component['score'] > 0 ? '+' : '' }}{{ $component['score'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            @endif
                        </div>
                    @elseif ($factor['type'] === 'list')
                        @if (!empty($factor['components']))
                            <details class="group/details">
                                <summary class="cursor-pointer select-none text-xs text-indigo-500 hover:text-indigo-600 transition">
                                    <span class="group-open/details:hidden">{{ __('Details') }}</span>

                                    <span class="hidden group-open/details:inline">{{ __('Скрыть подробности') }}</span>
                                </summary>

                                <div class="mt-2 pl-3 border-l border-slate-200 dark:border-slate-700 space-y-2">
                                    @foreach ($factor['components'] as $component)
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="min-w-0">
                                                <div class="text-xs text-slate-700 dark:text-slate-300">
                                                    {{ __('trustfactor.factors.' . $factor['name'] . '.components.' . $component['name'] . '.title') }}
                                                </div>
                                            </div>

                                            <span
                                                class="shrink-0 text-xxs font-mono px-1.5 py-0.5 rounded
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
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </details>
                        @endif
                    @else
                        <div class="flex items-center gap-2">
                            <div
                                class="{{ $factor['value'] ? 'opacity-20 ' : '' }}flex items-center gap-1.5 text-xs px-2 py-1 sm:py-1.5 rounded-lg border {{ $factor['penalty'] ? 'border-rose-500/30 bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-800 dark:text-slate-200' }} w-full justify-center">
                                @if ($factor['penalty'])
                                    <span class="font-mono">{{ $factor['penalty'] }}</span>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span>{{ __('Not passed') }}</span>
                                @endif
                            </div>

                            <div
                                class="{{ !$factor['value'] ? 'opacity-20 ' : '' }}flex items-center gap-1.5 text-xs px-2 py-1 sm:py-1.5 rounded-lg border {{ $factor['bonus'] ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-800 dark:text-slate-200' }} w-full justify-center">

                                @if ($factor['bonus'])
                                    <span class="font-mono">+{{ $factor['bonus'] }}</span>
                                @else
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Passed') }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
