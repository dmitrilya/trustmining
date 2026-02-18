<div class="w-full mt-4 sm:mt-6 lg:mt-0 space-y-4 sm:space-y-6 col-span-1">
    <div class="w-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
        <h2
            class="mb-1 sm:mb-3 p-2 xs:p-3 md:p-4 xs:text-lg sm:text-xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
            {{ __('Similar posts') }}
        </h2>

        <div class="divide-y divide-gray-100 dark:divide-zinc-800">
            @foreach ($similarQuestions as $similarQuestion)
                <a
                    href="{{ route('forum.question.show', [
                        'forumCategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->forumCategory->name)),
                        'forumSubcategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->name)),
                        'forumQuestion' => $similarQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $similarQuestion->theme)),
                    ]) }}">
                    <div class="p-2 xs:p-3 md:p-4 group hover:bg-gray-200 dark:hover:bg-zinc-950">
                        <div class="mb-1.5 sm:mb-2 text-xxs sm:text-xs lg:text-sm text-gray-500">
                            {{ __($similarQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($similarQuestion->forumSubcategory->name) }}
                        </div>

                        <h3
                            class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                            {{ $similarQuestion->theme }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <div class="w-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
        <h2
            class="mb-1 sm:mb-3 p-2 xs:p-3 md:p-4 xs:text-lg sm:text-xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
            {{ __('New posts') }}
        </h2>

        <div class="divide-y divide-gray-100 dark:divide-zinc-800">
            @foreach ($newQuestions as $newQuestion)
                <a
                    href="{{ route('forum.question.show', [
                        'forumCategory' => strtolower(str_replace(' ', '_', $newQuestion->forumSubcategory->forumCategory->name)),
                        'forumSubcategory' => strtolower(str_replace(' ', '_', $newQuestion->forumSubcategory->name)),
                        'forumQuestion' => $newQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $newQuestion->theme)),
                    ]) }}">
                    <div class="p-2 xs:p-3 md:p-4 group hover:bg-gray-200 dark:hover:bg-zinc-950">
                        <div class="mb-1.5 sm:mb-2 text-xxs sm:text-xs lg:text-sm text-gray-500">
                            {{ __($newQuestion->forumSubcategory->forumCategory->name) }}.
                            {{ __($newQuestion->forumSubcategory->name) }}
                        </div>

                        <h3
                            class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                            {{ $newQuestion->theme }}
                        </h3>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
