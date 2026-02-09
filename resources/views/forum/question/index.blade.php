<x-app-layout title="Форум по майнингу и криптовалюте TrustMining: список ваших вопросов"
    description="Посмотрите историю ваших вопросов, узнайте о процессе модерации и ознакомьтесь с похожими вопросами">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('My questions') }}
            </h1>

            <a class="block ml-auto w-fit"
                href="{{ route('forum.question.create') }}">
                <x-primary-button class="w-full">
                    {{ __('New question') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 lg:py-8">
        <div class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @foreach ($questions as $question)
                    @if ($question->published)
                        <a
                            href="{{ route('forum.question.show', [
                                'forumCategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->forumCategory->name)),
                                'forumSubcategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->name)),
                                'forumQuestion' => $question->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $question->theme)),
                            ]) }}">
                    @endif
                    <div class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-gray-200 dark:hover:bg-zinc-950">
                        <div class="mb-1.5 sm:mb-2 flex justify-between items-start">
                            @if ($question->moderation)
                                <div
                                    class="w-max cursor-default px-1 py-1 bg-gray-800 dark:bg-zinc-700 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                                    {{ __('Is under moderation') }}
                                </div>
                            @elseif (!$question->published)
                                <div
                                    class="w-max cursor-default px-1 py-1 bg-gray-800 dark:bg-zinc-700 opacity-60 border border-red-500 rounded-e-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                                    {{ __('Check out similar questions') }}
                                </div>
                            @else
                                <div class="text-xxs sm:text-xs lg:text-sm text-gray-500">
                                    {{ __($question->forumSubcategory->forumCategory->name) }}.
                                    {{ __($question->forumSubcategory->name) }}
                                </div>
                            @endif

                            <div class="text-right ml-3 sm:ml-5">
                                <div class="mb-0.5 sm:mb-1 text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                    {{ __('Views') }}: <span>{{ $question->views_count }}</span>
                                </div>
                                <div class="text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                    {{ __('Answers') }}:
                                    <span>{{ $question->moderated_forum_answers_count }}</span>
                                </div>
                            </div>
                        </div>

                        <h3
                            class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                            {{ $question->theme }}
                        </h3>

                        @if (count($question->similar_questions_list) && !$question->published)
                            <div x-data="{ show: false }"
                                class="mt-2 sm:mt-3 lg:mt-4 px-2 sm:px-4 h-full border-t border-gray-300 dark:border-zinc-700">
                                <div>
                                    <h3 id="accordion-flush-themes-heading">
                                        <button type="button" @click="show = !show"
                                            class="flex items-center justify-between w-full py-5 text-left rtl:text-right text-gray-800 dark:text-gray-200 text-xs sm:text-sm lg:text-base">
                                            <span>{{ __('Similar questions') }}</span>
                                            <svg class="w-3 h-3 shrink-0" :class="{ 'rotate-180': !show }"
                                                fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h3>
                                    <div x-show="show" style="display: none">
                                        <div class="py-3">
                                            <div class="space-y-2 sm:space-y-4">
                                                @foreach ($question->similar_questions_list as $similarQuestion)
                                                    <a target="_blank"
                                                        href="{{ route('forum.question.show', [
                                                            'forumCategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->forumCategory->name)),
                                                            'forumSubcategory' => strtolower(str_replace(' ', '_', $similarQuestion->forumSubcategory->name)),
                                                            'forumQuestion' => $similarQuestion->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $similarQuestion->theme)),
                                                        ]) }}">
                                                        <div
                                                            class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-gray-white dark:hover:bg-zinc-900 rounded-lg">
                                                            <div class="mb-1.5 sm:mb-2 flex justify-between">
                                                                <div
                                                                    class="text-xxs sm:text-xs lg:text-sm text-gray-500">
                                                                    {{ __($similarQuestion->forumSubcategory->forumCategory->name) }}.
                                                                    {{ __($similarQuestion->forumSubcategory->name) }}
                                                                </div>

                                                                <div class="text-right ml-3 sm:ml-5">
                                                                    <div
                                                                        class="mb-0.5 sm:mb-1 text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                                                        {{ __('Views') }}:
                                                                        <span>{{ $similarQuestion->views_count }}</span>
                                                                    </div>
                                                                    <div
                                                                        class="text-xxs sm:text-xs text-gray-500 whitespace-nowrap">
                                                                        {{ __('Answers') }}:
                                                                        <span>{{ $similarQuestion->moderated_forum_answers_count }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <h3
                                                                class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                                                                {{ $similarQuestion->theme }}
                                                            </h3>
                                                        </div>
                                                    </a>
                                                @endforeach

                                                <a class="block ml-auto w-full sm:w-fit mt-3 xs:mt-4 sm:mt-5 lg:mt-0"
                                                    href="{{ route('forum.question.publish', ['forumQuestion' => $question->id]) }}">
                                                    <x-primary-button class="w-full">
                                                        {{ __('There is no answer to my question') }}
                                                    </x-primary-button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($question->published)
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
