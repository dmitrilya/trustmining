<div
    class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden shadow shadow-logo-color rounded-xl">
    <h2 class="p-4 lg:mb-2 text-base text-gray-700 dark:text-gray-300 font-bold">
        {{ __('Latest forum questions') }}
    </h2>

    <div class="divide-y divide-gray-100 dark:divide-zinc-800">
        @foreach ($forumQuestions as $forumQuestion)
            <a
                href="{{ route('forum.question.show', [
                    'forumCategory' => strtolower(str_replace(' ', '_', $forumQuestion->forumSubcategory->forumCategory->name)),
                    'forumSubcategory' => strtolower(str_replace(' ', '_', $forumQuestion->forumSubcategory->name)),
                    'forumQuestion' => $forumQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $forumQuestion->theme)),
                ]) }}">
                <div
                    class="px-4 py-2 xs:py-3 sm:px-6 group bg-gray-100 dark:bg-zinc-950 hover:bg-gray-200 dark:hover:bg-zinc-800">
                    <div class="mb-1.5 sm:mb-2 flex justify-between">
                        <div class="text-xxs sm:text-xs text-gray-500">
                            {{ __($forumQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($forumQuestion->forumSubcategory->name) }}
                        </div>

                        <div class="text-right ml-3 sm:ml-5">
                            <div class="text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                {{ __('Views') }}: <span>{{ $forumQuestion->views_count }}</span>
                            </div>
                            <div class="text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                {{ __('Answers') }}:
                                <span>{{ $forumQuestion->moderated_forum_answers_count }}</span>
                            </div>
                        </div>
                    </div>

                    <h3
                        class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-gray-100">
                        {{ $forumQuestion->theme }}
                    </h3>
                </div>
            </a>
        @endforeach
    </div>
</div>
