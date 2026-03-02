<div class="w-full mt-4 sm:mt-6 lg:mt-0 space-y-4 sm:space-y-6 col-span-1">
    <div class="w-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
        <h2
            class="mb-1 sm:mb-3 p-2 xs:p-3 md:p-4 xs:text-lg sm:text-xl text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 font-bold">
            {{ __('Similar posts') }}
        </h2>

        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @foreach ($similarQuestions as $similarQuestion)
                <a
                    href="{{ route('forum.question.show', [
                        'forumCategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->forumCategory->name)),
                        'forumSubcategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->name)),
                        'forumQuestion' => $similarQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $similarQuestion->theme)),
                    ]) }}">
                    <div class="p-2 xs:p-3 md:p-4 group hover:bg-slate-200 dark:hover:bg-slate-950">
                        <div class="mb-1.5 sm:mb-2 text-xxs sm:text-xs lg:text-sm text-slate-500">
                            {{ __($similarQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($similarQuestion->forumSubcategory->name) }}
                        </div>

                        <h3
                            class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-700 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100 font-bold">
                            {{ $similarQuestion->theme }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="w-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
        <h2
            class="mb-1 sm:mb-3 p-2 xs:p-3 md:p-4 xs:text-lg sm:text-xl text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 font-bold">
            {{ __('New posts') }}
        </h2>

        <div class="divide-y divide-slate-100 dark:divide-slate-800">
            @foreach ($newQuestions as $newQuestion)
                <a
                    href="{{ route('forum.question.show', [
                        'forumCategory' => strtolower(str_replace(' ', '_', $newQuestion->forumSubcategory->forumCategory->name)),
                        'forumSubcategory' => strtolower(str_replace(' ', '_', $newQuestion->forumSubcategory->name)),
                        'forumQuestion' => $newQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $newQuestion->theme)),
                    ]) }}">
                    <div class="p-2 xs:p-3 md:p-4 group hover:bg-slate-200 dark:hover:bg-slate-950">
                        <div class="mb-1.5 sm:mb-2 text-xxs sm:text-xs lg:text-sm text-slate-500">
                            {{ __($newQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($newQuestion->forumSubcategory->name) }}
                        </div>

                        <h3
                            class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-700 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100 font-bold">
                            {{ $newQuestion->theme }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
