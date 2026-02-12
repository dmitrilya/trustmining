<x-app-layout title="Форум TrustMining: {{ __($subcategory->name) }}"
    description="Найдите ответ на вопрос среди постов из раздела {{ __($category->name) }} категории {{ __($category->name) }} или задайте свой">
    <x-slot name="header">
        <div class="lg:flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center sm:space-x-2">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="1" />
                        <div class="flex items-center">
                            <a itemprop="item" href="{{ route('forum') }}"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __('Forum') }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('forum.category', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name))]) }}"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __($category->name) }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                        class="text-sm truncate">
                        <meta itemprop="position" content="3" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="text-gray-600 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-300">
                                <span itemprop="name">{{ __($subcategory->name) }}</span>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex justify-end mt-3 xs:mt-4 sm:mt-5 lg:mt-0">
                <a class="mr-1 xs:mr-2" href="{{ route('forum.question.index') }}">
                    <x-secondary-button
                        class="bg-secondary-gradient dark:text-gray-800">{{ __('My questions') }}</x-secondary-button>
                </a>
                <a class="" href="{{ route('forum.question.create') }}">
                    <x-primary-button>
                        {{ __('New question') }}
                    </x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg">
            <h1
                class="mb-1 sm:mb-3 lg:mb-5 p-4 md:p-6 xs:text-lg sm:text-xl lg:text-2xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                {{ __($subcategory->name) }}
            </h1>

            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @foreach ($questions as $question)
                    <a
                        href="{{ route('forum.question.show', [
                            'forumCategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->forumCategory->name)),
                            'forumSubcategory' => strtolower(str_replace(' ', '_', $question->forumSubcategory->name)),
                            'forumQuestion' => $question->id . '-' . mb_strtolower(str_replace([' ', '/'], '-', $question->theme)),
                        ]) }}">
                        <div class="px-4 py-2 xs:py-3 sm:px-6 group hover:bg-gray-200 dark:hover:bg-zinc-950">
                            <div class="mb-1.5 sm:mb-2 flex justify-between">
                                <div class="text-xxs sm:text-xs lg:text-sm text-gray-500">
                                    {{ __($question->forumSubcategory->forumCategory->name) }}.
                                    {{ __($question->forumSubcategory->name) }}
                                </div>

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
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 sm:mt-12 lg:mt-16">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
