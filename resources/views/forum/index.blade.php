<x-app-layout title="Форум TrustMining"
    description="Найдите ответ на вопрос среди постов на форуме TrustMining или задайте свой на любую тему из криптосферы">
    <x-slot name="header">
        <div class="lg:flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center sm:space-x-2">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="1" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="text-slate-600 dark:text-slate-300 hover:text-slate-600 dark:hover:text-slate-300">
                                <span itemprop="name">{{ __('Forum') }}</span>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex justify-end mt-3 xs:mt-4 sm:mt-5 lg:mt-0">
                <a class="mr-1 xs:mr-2" href="{{ route('forum.question.index') }}">
                    <x-secondary-button
                        class="bg-secondary-gradient dark:text-slate-800">{{ __('My questions') }}</x-secondary-button>
                </a>
                <a class="" href="{{ route('forum.question.create') }}">
                    <x-primary-button>
                        {{ __('New question') }}
                    </x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-5 xl:gap-7">
        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
            <h2
                class="mb-1 sm:mb-3 lg:mb-5 p-4 md:p-6 xs:text-lg sm:text-xl lg:text-2xl text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 font-bold">
                {{ __('New posts') }}
            </h2>

            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($questions as $question)
                    <a
                        href="{{ route('forum.question.show', [
                            'forumCategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->forumCategory->name)),
                            'forumSubcategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->name)),
                            'forumQuestion' => $question->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $question->theme)),
                        ]) }}">
                        <div class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-slate-200 dark:hover:bg-slate-950">
                            <div class="mb-1.5 sm:mb-2 flex justify-between">
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
                                class="whitespace-nowrap truncate text-xs sm:text-sm lg:text-base text-slate-700 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-100 font-bold">
                                {{ $question->theme }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @foreach ($categories as $category)
            <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
                <h2 class="mb-1 sm:mb-3 lg:mb-5 p-4 md:p-6">
                    <a href="{{ route('forum.category', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name))]) }}"
                        class="xs:text-lg sm:text-xl lg:text-2xl text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-slate-100 font-bold">
                        {{ __($category->name) }}
                    </a>
                </h2>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($category->forumSubcategories as $subcategory)
                        <a
                            href="{{ route('forum.subcategory', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name)), 'forumSubcategory' => strtolower(str_replace(' ', '_', $subcategory->name))]) }}">
                            <div
                                class="px-4 py-2 xs:py-3 sm:px-6 sm:py-4 group hover:bg-slate-200 dark:hover:bg-slate-950 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="mr-3 sm:mr-4 size-6 min-w-6 xs:size-8 xs:min-w-8 sm:size-10 sm:min-w-10 lg:size-12 lg:min-w-12 rounded-full group-hover:shadow-lg shadow-logo-color border-[1.5px] border-slate-500 dark:border-slate-500 group-hover:border-slate-900 dark:group-hover:border-slate-100 flex items-center justify-center">
                                        @include(
                                            'forum.components.svg.' .
                                                strtolower(str_replace(' ', '_', $subcategory->name)),
                                            [
                                                'class' =>
                                                    'text-slate-500 dark:text-slate-500 group-hover:text-slate-900 dark:group-hover:text-slate-100',
                                                'w' => '55%',
                                            ]
                                        )
                                    </div>
                                    <h3
                                        class="text-xs xs:text-sm sm:text-base lg:text-lg text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 font-bold">
                                        {{ __($subcategory->name) }}
                                    </h3>
                                </div>

                                <div class="text-right ml-3 sm:ml-5">
                                    <div class="text-xxs sm:text-xs lg:text-sm text-slate-500 whitespace-nowrap">
                                        {{ __('Posts') }}: {{ $subcategory->published_forum_questions_count }}
                                    </div>
                                    @if ($subcategory->latestForumQuestion)
                                        <div class="date-transform mt-0.5 sm:mt-1 text-xxs sm:text-xs lg:text-sm text-slate-500 whitespace-nowrap"
                                            data-date={{ $subcategory->latestForumQuestion->created_at }}></div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
