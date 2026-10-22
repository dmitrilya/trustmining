@props(['category', 'candidate' => null, 'type' => 'block'])

@php
    $currentMonth = (int) now()->format('Ym');
    $totalParticipants = $category->applyFilter($category->modelClass()::query())->count();

    $results = DB::table('votes')
        ->select('voteable_id', DB::raw('COUNT(*) as total_votes'))
        ->where('year_month', $currentMonth)
        ->where('category_id', $category->value)
        ->where('voteable_type', $category->morphClass())
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

    $class = $type == 'widjet' ? 'p-2 sm:p-3' : 'p-2 sm:p-4 md:p-6 mt-2 sm:mt-4';
@endphp

<div {{ $attributes->merge(['class' => $class . ' bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl']) }}
    x-data="votingWidget('{{ route('voting.vote', $category->slug()) }}', '{{ $category->morphClass() }}', {{ collect(['Vote' => __('Vote'), 'Vote counted' => __('Vote counted'), 'Network error. Please try again' => __('Network error. Please try again')]) }})">
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

    <div class="grid grid-cols-1 gap-6{{ isset($candidate) ? ' md:grid-cols-12' : '' }}">
        @if (isset($widjetCandidate))
            @php
                $rank = 0;
                $votes = 0;
                foreach ($results as $index => $row) {
                    if ($row->voteable_id == $company->id) {
                        $rank = $index + 1;
                        $companyVotes = $row->total_votes;
                        break;
                    }
                }

                if ($rank === 0) {
                    $rank = $results->count() + 1;
                }

                $candidate = [
                    'id' => $company->id,
                    'rank' => $rank,
                    'votes' => $votes,
                ];
            @endphp

            <div
                class="md:col-span-5 flex flex-col justify-between p-4 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl">
                <div class="text-center md:text-left">
                    <h3 class="text-xs text-slate-500 uppercase tracking-widest block">{{ __('Current status of the company') }}</h3>
                    <div class="mt-2 flex items-baseline justify-center md:justify-start gap-2">
                        <span class="text-4xl font-extrabold text-indigo-500">#{{ $candidate['rank'] }}</span>
                        <span class="text-sm text-slate-600 dark:text-slate-400">место из {{ $totalParticipants }}</span>
                    </div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-2">
                        {{ __('Total votes received:') }} <span class="font-bold text-slate-800 dark:text-slate-200"
                            x-text="votesCount">{{ $candidate['votes'] }}</span>
                    </p>
                </div>

                <div class="mt-4">
                    <x-buttons.primary-button class="block ml-auto" @click="submitVote({{ $candidate['id'] ?? null }})" @disabled="loading || voted">
                        <span x-text="getButtonText({{ $candidate['id'] }})">{{ __('Vote') }}</span>
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

        @if ($type == 'widjet')
            <a href="{{ route('voting.show', $category->slug()) }}" class="w-full">
                <x-buttons.primary-button class="w-full">{{ __('Vote') }}</x-buttons.primary-button>
            </a>
        @endif
    </div>
</div>
