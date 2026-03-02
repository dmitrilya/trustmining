<div
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl">
    <h2 class="p-4 lg:mb-2 text-base text-slate-700 dark:text-slate-300 font-bold">
        {{ __('Latest forum questions') }}
    </h2>

    <div class="divide-y divide-slate-100 dark:divide-slate-800">
        @foreach ($forumQuestions as $forumQuestion)
            <a
                href="{{ route('forum.question.show', [
                    'forumCategory' => strtolower(str_replace(' ', '_', $forumQuestion->forumSubcategory->forumCategory->name)),
                    'forumSubcategory' => strtolower(str_replace(' ', '_', $forumQuestion->forumSubcategory->name)),
                    'forumQuestion' => $forumQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $forumQuestion->theme)),
                ]) }}">
                <div
                    class="px-4 py-2 xs:py-3 sm:px-6 group bg-slate-100 dark:bg-slate-950 hover:bg-slate-200 dark:hover:bg-slate-800">
                    <div class="mb-1.5 sm:mb-2 flex justify-between">
                        <div class="text-xxs sm:text-xs text-slate-500">
                            {{ __($forumQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($forumQuestion->forumSubcategory->name) }}
                        </div>

                        <div class="text-right ml-3 sm:ml-5">
                            {{-- <div class="text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                {{ __('Views') }}: <span>{{ $forumQuestion->views_count }}</span>
                            </div> --}}
                            <div class="text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                {{ __('Answers') }}:
                                <span>{{ $forumQuestion->moderated_forum_answers_count }}</span>
                            </div>
                        </div>
                    </div>

                    <h3
                        class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-slate-100">
                        {{ $forumQuestion->theme }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
</div>
