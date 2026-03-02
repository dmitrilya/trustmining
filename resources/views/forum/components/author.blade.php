<div itemprop="author" itemscope itemtype="https://schema.org/Person"
    class="mb-2 sm:mb-4{{ isset($sm) ? '' : ' lg:mb-6' }} flex items-center">
    <div
        class="{{ isset($sm) ? 'size-10 sm:size-12' : 'size-12 sm:size-14 lg:size-16 lg:mr-4' }} mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5">
        <img itemprop="image"
            src="{{ Storage::disk('public')->exists('forum/avatar_' . $id . '.webp') ? Storage::url('public/forum/avatar_' . $id . '.webp') : Storage::url('public/forum/avatar_0.webp') }}"
            alt="{{ $name }}" class="w-full rounded-full">
    </div>

    @php
        $prevRankScore = 0;
        foreach ($ranks as $rankScore => $rank) {
            if ($forumScore < $rankScore) {
                break;
            }

            $prevRankScore = $rankScore;
        }
    @endphp

    <div>
        <h4 itemprop="name"
            class="{{ isset($sm) ? 'mb-0.5 sm:mb-1 lg:text-sm' : 'mb-1 sm:mb-1.5 sm:text-sm lg:text-base' }} text-xs text-slate-700 dark:text-slate-300 font-bold">
            {{ $name }}</h4>
        <div class="flex items-center{{ isset($sm) ? '' : ' xs:mb-0.5' }}" x-data="{ open: false }">
            <svg class="{{ isset($sm) ? 'size-3 sm:size-4' : 'size-4 sm:size-5' }} text-slate-500" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
            </svg>

            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-slate-500">
                {{ __($rank) }}</div>

            <div class="relative">
                <div class="ml-1 sm:ml-2 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200"
                    @mouseover="open = true" @mouseover.away = "open = false" @click="open = !open"
                    @click.away="open = false">
                    <svg class="size-4 sm:size-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>

                <div x-show="open" style="display: none"
                    class="absolute top-7 left-1/2 -translate-x-1/2 px-2 py-3 sm:px-4 sm:py-5 space-y-3 sm:space-y-5 bg-slate-50 dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-lg z-20">
                    <div class="flex justify-center items-center">
                        <svg class="{{ isset($sm) ? 'size-3 sm:size-4' : 'size-4 sm:size-5' }} text-slate-500"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="m7.171 12.906-2.153 6.411 2.672-.89 1.568 2.34 1.825-5.183m5.73-2.678 2.154 6.411-2.673-.89-1.568 2.34-1.825-5.183M9.165 4.3c.58.068 1.153-.17 1.515-.628a1.681 1.681 0 0 1 2.64 0 1.68 1.68 0 0 0 1.515.628 1.681 1.681 0 0 1 1.866 1.866c-.068.58.17 1.154.628 1.516a1.681 1.681 0 0 1 0 2.639 1.682 1.682 0 0 0-.628 1.515 1.681 1.681 0 0 1-1.866 1.866 1.681 1.681 0 0 0-1.516.628 1.681 1.681 0 0 1-2.639 0 1.681 1.681 0 0 0-1.515-.628 1.681 1.681 0 0 1-1.867-1.866 1.681 1.681 0 0 0-.627-1.515 1.681 1.681 0 0 1 0-2.64c.458-.361.696-.935.627-1.515A1.681 1.681 0 0 1 9.165 4.3ZM14 9a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                        </svg>
                        <div
                            class="ml-2 sm:ml-3 text-xs xs:text-sm sm:text-base text-slate-700 dark:text-slate-300">
                            {{ __($rank) }} ({{ $forumScore }})
                        </div>
                    </div>

                    <div class="flex items-center">
                        <p class="text-xxs xs:text-xs text-slate-500">{{ $prevRankScore }}</p>
                        <div class="mx-2 w-full bg-slate-200 rounded-full h-1.5 dark:bg-slate-700">
                            <div class="bg-indigo-600 h-1.5 rounded-full"
                                style="width: {{ (($forumScore - $prevRankScore) / ($rankScore - $prevRankScore)) * 100 }}%">
                            </div>
                        </div>
                        <p class="text-xxs xs:text-xs text-slate-500">{{ $rankScore }}</p>
                    </div>

                    <div class="space-y-0.5 sm:space-y-1">
                        @foreach ($ranks as $rankScore => $rank)
                            <p class="whitespace-nowrap text-xs xs:text-sm text-slate-700 dark:text-slate-300">{{ __($rank) }} <span class="text-slate-500">- {{ $rankScore }} {{ __('points') }}</span></p>
                        @endforeach
                    </div>

                    <div class="space-y-0.5 sm:space-y-1">
                        <p class="whitespace-nowrap text-xs xs:text-sm text-slate-700 dark:text-slate-300">{{ __('Answer to the question') }} <span class="text-slate-500">- {{ $answerPoints }} {{ __('point') }}</span></p>
                        <p class="whitespace-nowrap text-xs xs:text-sm text-slate-700 dark:text-slate-300">{{ __('Helpful answer') }} <span class="text-slate-500">- {{ $helpfulAnswerPoints }} {{ __('points') }}</span></p>
                        <p class="whitespace-nowrap text-xs xs:text-sm text-slate-700 dark:text-slate-300">{{ __('Best answer') }} <span class="text-slate-500">- {{ $bestAnswerPoints }} {{ __('points') }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <svg class="{{ isset($sm) ? 'size-3 sm:size-4' : 'size-4 sm:size-5' }} text-slate-500" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M16 10.5h.01m-4.01 0h.01M8 10.5h.01M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.6a1 1 0 0 0-.69.275l-2.866 2.723A.5.5 0 0 1 8 18.635V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
            </svg>

            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs{{ isset($sm) ? '' : ' lg:text-sm' }} text-slate-500">
                {{ $messages }}</div>
        </div>
    </div>
</div>
