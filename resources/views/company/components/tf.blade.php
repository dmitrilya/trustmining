<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start gap-4 sm:gap-6">
        <div class="max-w-lg">
            <h2 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200">{{ __('Company reliability analysis') }}</h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1">
                {{ __('The criteria and their strictness depend on the main activity of the company and the presence of certain announcements') }}
            </p>
        </div>
        <div class="w-full sm:w-fit flex flex-col items-center text-xs px-4 py-2 rounded-xl bg-indigo-500/10 border border-indigo-600">
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
                        @if (in_array($factor['type'], ['threshold', 'threshold_reverse', 'group', 'threshold_group', 'list']))
                            <span
                                class="whitespace-nowrap text-xs px-2 py-0.5 rounded-full font-mono
                                {{ $factor['score'] > 0 ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : ($factor['score'] < 0 ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400') }}">
                                {{ $factor['score'] > 0 ? '+' : '' }}{{ $factor['score'] }} pts
                            </span>
                        @endif

                        @if ($factor['type'] === 'boolean')
                            @if ($factor['value'] && $factor['bonus'] > 0)
                                <span class="whitespace-nowrap text-xxs text-emerald-600 dark:text-emerald-400 mt-1">{{ __('Bonus received') }}</span>
                            @elseif(!$factor['value'] && $factor['penalty'] < 0)
                                <span class="whitespace-nowrap text-xxs text-rose-600 dark:text-rose-400 mt-1">{{ __('Penalty applied') }}</span>
                            @endif
                        @endif
                    </div>
                </div>

                <div>
                    @if (in_array($factor['type'], ['threshold', 'threshold_reverse']))
                        @include('company.components.tf-threshold')
                    @elseif (in_array($factor['type'], ['group', 'threshold_group']))
                        @include('company.components.tf-group')
                    @elseif ($factor['type'] === 'list' && !empty($factor['components']))
                        @include('company.components.tf-list')
                    @else
                        <div class="flex items-center gap-2">
                            <div
                                class="{{ $factor['value'] ? 'opacity-25 ' : '' }}flex items-center gap-1.5 text-xs px-2 py-1 sm:py-1.5 rounded-lg border {{ $factor['penalty'] ? 'border-rose-500/30 bg-rose-500/10 text-rose-600 dark:text-rose-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-800 dark:text-slate-200' }} w-full justify-center">
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
                                class="{{ !$factor['value'] ? 'opacity-25 ' : '' }}flex items-center gap-1.5 text-xs px-2 py-1 sm:py-1.5 rounded-lg border {{ $factor['bonus'] ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'border-slate-300 dark:border-slate-700 bg-white/40 dark:bg-slate-900/40 text-slate-800 dark:text-slate-200' }} w-full justify-center">

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
