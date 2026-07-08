<x-app-layout title="Список вопросов | TRUSTMINING Форум"
    description="Список всех вопросов на форуме TrustMining">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ __('All forum questions') }}
            </h1>

            <a class="block ml-auto w-fit" href="{{ route('forum.question.create') }}">
                <x-buttons.primary-button class="w-full">
                    {{ __('New question') }}
                </x-buttons.primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl">
            <div class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach ($questions as $question)
                    <a
                        href="{{ route('forum.question.show', [
                            'forumCategory' => $question->forumSubcategory->forumCategory->slug,
                            'forumSubcategory' => $question->forumSubcategory->slug,
                            'forumQuestion' => $question->id . '-' . Str::slug($question->theme),
                        ]) }}">
                        <div class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-slate-200 dark:hover:bg-slate-950">
                            <div class="mb-1.5 sm:mb-2 flex justify-between items-start">
                                <div class="text-xxs sm:text-xs lg:text-sm text-slate-500">
                                    {{ __($question->forumSubcategory->forumCategory->name) }}.
                                    {{ __($question->forumSubcategory->name) }}
                                </div>

                                <div class="text-right ml-3 sm:ml-5">
                                    <div class="mb-0.5 sm:mb-1 text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                        {{ __('Views') }}: <span>{{ $question->views_count }}</span>
                                    </div>
                                    <div class="text-xxs sm:text-xs text-slate-500 whitespace-nowrap">
                                        {{ __('Answers') }}:
                                        <span>{{ $question->moderated_forum_answers_count }}</span>
                                    </div>
                                </div>
                            </div>

                            <h3
                                class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 font-bold">
                                {{ $question->theme }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>

            @if ($questions->hasPages())
                <div class="mt-8 sm:mt-12 lg:mt-14">
                    {{ $questions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
