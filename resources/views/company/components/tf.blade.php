<div
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-10">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-300 dark:border-slate-700">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200">{{ __('Company reliability analysis') }}</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                    {{ __('Main direction') }}: <span class="text-indigo-500 uppercase">{{ __('trustfactor.directions.' . $tfData['direction']) }}</span>
                </p>
            </div>
            {{-- <div
                class="flex items-center gap-3 px-4 py-2 rounded-xl border {{ $tfData['tf'] > config('trustfactor.yellow') ? ($tfData['tf'] > config('trustfactor.green') ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-600 dark:text-emerald-400' : 'bg-amber-500/10 border-amber-500/30 text-amber-600 dark:text-amber-400') : 'bg-rose-500/10 border-rose-500/30 text-rose-600 dark:text-rose-400' }}">
                <span class="text-sm">{{ __('Final trust factor') }} (TF):</span>
                <span class="text-2xl font-black">{{ $tfData['tf'] }}%</span>
            </div> --}}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4">
            @foreach ($tfData['factors'] as $factor)
                <div class="p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 flex flex-col justify-between">
                    <div class="flex justify-between items-start gap-4 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-800 dark:text-slate-200 text-sm tracking-wide">
                                {{ __('trustfactor.factors.' . $factor['name'] . '.title') }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5">
                                {{ __('trustfactor.factors.' . $factor['name'] . '.description') }}</span>
                            </p>
                        </div>

                        <div class="flex flex-col items-end">
                            @if ($factor['type'] === 'threshold')
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
                        @if ($factor['type'] === 'threshold')
                            <div class="space-y-1.5">
                                <div class="relative w-full h-2 rounded-full overflow-hidden">
                                    @php
                                        $sortedThresholds = $factor['thresholds'];
                                        asort($sortedThresholds);

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

                                            <div class="h-full {{ $loop->first ? 'border-r' : ($loop->last ? 'border-l' : 'border-x') }} border-slate-300 transition-opacity duration-300 {{ !$isActive ? 'opacity-20 select-none pointer-events-none' : 'opacity-100 z-10' }}"
                                                style="
                                                    width: {{ $segmentWidth }}%; 
                                                    background: linear-gradient(to right, var(--tw-gradient-stops));
                                                    --tw-gradient-from: #f43f5e var(--tw-gradient-from-position, 0%);
                                                    --tw-gradient-to: #10b981 var(--tw-gradient-to-position, 100%);
                                                    --tw-gradient-stops: var(--tw-gradient-from), #f59e0b {{ 50 }}%, var(--tw-gradient-to);
                                                    background-size: {{ $count * 100 }}% 100%;
                                                    background-position: -{{ $i * 100 }}% 0;
                                                ">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flex justify-between text-xxs font-mono text-slate-500 px-0.5">
                                    <span>{{ $thresholdKeys[0] }}</span>
                                    <span class="text-slate-600 dark:text-slate-400">{{ $factor['value'] }}</span>
                                    <span>{{ end($thresholdKeys) }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <div
                                    class="{{ $factor['value'] ? 'opacity-20 ' : '' }}flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-lg border {{ $factor['penalty'] ? 'border-rose-500/30 bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400' }} w-full justify-center">
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
                                    class="{{ !$factor['value'] ? 'opacity-20 ' : '' }}flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-lg border {{ $factor['bonus'] ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400' }} w-full justify-center">

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
</div>
