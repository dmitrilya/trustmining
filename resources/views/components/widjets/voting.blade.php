@props(['category', 'candidate' => null, 'type' => 'block'])

@php
    $period = $category->period();
    $roundId = $period->currentRoundId();
    $morphClass = $category->morphClass();

    $class = $type == 'widjet' ? 'p-2 sm:p-3' : 'p-2 sm:p-4 md:p-6 mt-2 sm:mt-4';
@endphp

<div {{ $attributes->merge(['class' => $class . ' bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl']) }}
    x-data="votingWidget('{{ route('voting.vote', $category->slug()) }}', {{ collect(['Vote' => __('Vote'), 'Growth' => __('Growth'), 'Depreciation' => __('Depreciation'), 'Vote counted' => __('Vote counted'), 'Network error. Please try again' => __('Network error. Please try again')]) }})">
    @if ($category === App\Enums\VotingCategory::coin_rate_prediction)
        <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4">
            {{ $category->name() }} {{ $candidate->abbreviation }}
        </h2>

        @php
            $id = $candidate->id;
            $result = DB::table('votes')
                ->select([
                    DB::raw('COUNT(*) as total_predictions'),
                    DB::raw("SUM(CASE WHEN voteable_type = 'coin_up' THEN 1 ELSE 0 END) as up_votes"),
                    DB::raw("SUM(CASE WHEN voteable_type = 'coin_down' THEN 1 ELSE 0 END) as down_votes"),
                ])
                ->where('category_id', $category->value)
                ->where('voteable_id', $candidate->id)
                ->where('round_id', $roundId)
                ->first();
        @endphp

        <div x-data="{ up: {{ $result->up_votes ?? 0 }}, down: {{ $result->down_votes ?? 0 }}, total: {{ $result->total_predictions ?? 0 }}, get upPercent() { return this.total == 0 ? 50 : this.up / this.total * 100 }, get downPercent() { return this.total == 0 ? 50 : this.down / this.total * 100 } }">
            <div class="flex flex-wrap gap-y-4 gap-x-8">
                <div class="flex items-center">
                    <img alt="{{ $candidate->name }} icon" class="w-12 mr-1 xs:mr-2"
                        src="{{ Storage::url('public/coins/64/' . $candidate->abbreviation . '.webp') }}" />
                    <div>
                        <div class="text-xs xs:text-sm text-slate-600 dark:text-slate-400">
                            {{ $candidate->name }}
                        </div>
                        <div class="text-sm xs:text-base lg:text-lg text-slate-800 dark:text-slate-200 font-bold">
                            {{ adjust_rate($candidate->rate) }} <span class="text-xs lg:text-sm text-slate-600 dark:text-slate-400">USDT</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col grow">
                    <x-buttons.secondary-button class="block w-full" variant="emerald" @click="up++; total++; submitVote('coin_up', {{ $id }})"
                        ::disabled="isButtonDisabled('coin_up', {{ $id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5" aria-hidden="true">
                            <path d="M16 7h6v6"></path>
                            <path d="m22 7-8.5 8.5-5-5L2 17"></path>
                        </svg>
                        <span>{{ __('Growth') }}</span>
                    </x-buttons.secondary-button>

                    <x-buttons.secondary-button class="mt-2 block w-full" variant="rose" @click="down++; total++; submitVote('coin_down', {{ $id }})"
                        ::disabled="isButtonDisabled('coin_down', {{ $id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-5" aria-hidden="true">
                            <path d="M16 17h6v-6"></path>
                            <path d="m22 17-8.5-8.5-5 5L2 7"></path>
                        </svg>
                        <span>{{ __('Depreciation') }}</span>
                    </x-buttons.secondary-button>
                </div>

                <p x-show="message" x-text="message" :class="isError ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400'"
                    class="text-xs text-center font-medium mt-2" x-cloak></p>
            </div>

            <div class="grid grid-cols-2 gap-4 text-center relative mt-4">
                <div class="flex flex-col items-center">
                    <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400" x-text="up">{{ $result->up_votes ?? 0 }}</span>
                    <span class="text-xxs text-slate-500 uppercase tracking-wider">Прогнозов вверх</span>

                </div>

                <div class="flex flex-col items-center">
                    <span class="text-2xl font-black text-rose-600 dark:text-rose-400" x-text="down">{{ $result->down_votes ?? 0 }}</span>
                    <span class="text-xxs text-slate-500 uppercase tracking-wider">Прогнозов вниз</span>
                </div>

                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-full px-1.5 py-0.5 text-xxs font-bold text-slate-500">
                    VS
                </div>
            </div>

            <div class="flex justify-between gap-1 h-1.5 mt-2 overflow-hidden">
                <div class="bg-emerald-500 h-full rounded-full" :style="`width: ${upPercent}%`"
                    style="width: {{ $result->total_predictions == 0 ? 50 : ($result->up_votes / $result->total_predictions) * 100 }}%"></div>
                <div class="bg-rose-500 h-full rounded-full" :style="`width: ${downPercent}%`"
                    style="width: {{ $result->total_predictions == 0 ? 50 : ($result->down_votes / $result->total_predictions) * 100 }}%"></div>
            </div>
        </div>
    @else
        @php
            $totalParticipants = $category->applyFilter($category->modelClass()::query())->count();

            $results = DB::table('votes')
                ->select('voteable_id', DB::raw('COUNT(*) as total_votes'))
                ->where('round_id', $roundId)
                ->where('category_id', $category->value)
                ->where('voteable_type', $morphClass)
                ->groupBy('voteable_id')
                ->orderByDesc('total_votes')
                ->get();

            $topThreeIds = $results->take(3)->pluck('voteable_id')->toArray();
            $topCandidates = $category
                ->modelClass()
                ::whereIn('id', $topThreeIds)
                ->get()
                ->sortBy(function ($model) use ($topThreeIds) {
                    return array_search($model->id, $topThreeIds);
                });
        @endphp

        @if ($type == 'block')
            <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">
                        {{ $category->name() }}
                    </h2>

                    <p class="text-slate-600 dark:text-slate-400 mt-1">
                        {{ $category->caption() }}
                    </p>
                </div>
                <a href="{{ route('voting.show', $category->slug()) }}" class="text-xs font-medium text-indigo-500 hover:text-indigo-600 whitespace-nowrap">
                    {{ __('Full list of candidates') }} →
                </a>
            </div>
        @else
            <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4">
                {{ $category->name() }}
            </h2>
        @endif
        <div class="min-w-0 grid grid-cols-1 gap-6{{ isset($candidate) ? ' md:grid-cols-12' : '' }}">
            @if (isset($candidate))
                @php
                    $id = $candidate->id;
                    $rank = 0;
                    $votes = 0;
                    foreach ($results as $index => $row) {
                        if ($row->voteable_id == $candidate->id) {
                            $rank = $index + 1;
                            $votes = $row->total_votes;
                            break;
                        }
                    }

                    if ($rank === 0) {
                        $rank = $results->count() + 1;
                    }
                @endphp

                <div
                    class="md:col-span-5 flex flex-col justify-between p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl">
                    <div class="text-center md:text-left">
                        <h3 class="text-xs text-slate-500 uppercase tracking-widest block">{{ __('Current status of the company') }}</h3>
                        <div class="mt-2 flex items-baseline justify-center md:justify-start gap-2">
                            <span class="text-4xl font-extrabold text-indigo-500">#{{ $rank }}</span>
                            <span class="text-sm text-slate-600 dark:text-slate-400">{{ __('place out of') }} {{ $totalParticipants }}</span>
                        </div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-2">
                            {{ __('Total votes received:') }} <span class="font-bold text-slate-800 dark:text-slate-200">{{ $votes }}</span>
                        </p>
                    </div>

                    <div class="mt-4">
                        <x-buttons.primary-button class="block ml-auto" @click="submitVote('{{ $morphClass }}', {{ $id }})"
                            @disabled="isButtonDisabled('{{ $morphClass }}', {{ $id }})">
                            <span x-text="getButtonText('{{ $morphClass }}', {{ $id }})">{{ __('Vote') }}</span>
                        </x-buttons.primary-button>

                        <p x-show="message" x-text="message" :class="isError ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400'"
                            class="text-xs text-center font-medium mt-2" x-cloak></p>
                    </div>
                </div>
            @endif

            <div class="{{ isset($candidate) ? 'md:col-span-7 ' : '' }}flex flex-col justify-center">
                @if ($type == 'block')
                    <span class="text-xs text-slate-400 uppercase tracking-wider mb-2 block">{{ __('This month\'s leaders') }}</span>
                @endif

                <div class="space-y-2">
                    @forelse($topCandidates as $index => $topCandidate)
                        <div class="flex items-center justify-between p-2 border border-indigo-500/30 bg-indigo-500/10 rounded-xl">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold w-5 text-center">
                                    {{ match ($index + 1) {1 => '🥇',2 => '🥈',3 => '🥉',default => $index + 1} }}
                                </span>
                                <span class="text-sm text-slate-800 dark:text-slate-200">
                                    {{ $topCandidate->name }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-sm text-slate-500 italic p-4 text-center border border-dashed border-slate-300 dark:border-slate-700 rounded-xl">
                            {{ __('Voting has just begun. Be the first!') }}
                        </div>
                    @endforelse
                </div>
            </div>

            @if ($type == 'widjet' && !$candidate)
                <a href="{{ route('voting.show', $category->slug()) }}" class="w-full">
                    <x-buttons.primary-button class="w-full">{{ __('Vote') }}</x-buttons.primary-button>
                </a>
            @endif
        </div>
    @endif
</div>
