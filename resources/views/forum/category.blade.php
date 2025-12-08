<x-app-layout title="Форум TrustMining: {{ __($category->name) }}"
    description="Найдите ответ на вопрос среди постов из раздела {{ __($category->name) }} или задайте свой">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center space-x-2">
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
                            <a itemprop="item" href="#"
                                class="text-gray-600 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-300">
                                <span itemprop="name">{{ __($category->name) }}</span>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <a href="{{ route('forum.question.create') }}">
                <x-primary-button>
                    {{ __('New question') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg">
            <h2 class="mb-1 sm:mb-3 lg:mb-5 p-4 md:p-6">
                <a href="{{ route('forum.category', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name))]) }}"
                    class="xs:text-lg sm:text-xl lg:text-2xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                    {{ __($category->name) }}
                </a>
            </h2>

            <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                @foreach ($subcategories as $subcategory)
                    <a
                        href="{{ route('forum.subcategory', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name)), 'forumSubcategory' => strtolower(str_replace(' ', '_', $subcategory->name))]) }}">
                        <div
                            class="px-4 py-2 xs:py-3 sm:px-6 sm:py-4 group hover:bg-gray-200 dark:hover:bg-zinc-950 flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="mr-3 sm:mr-4 size-6 min-w-6 xs:size-8 xs:min-w-8 sm:size-10 sm:min-w-10 lg:size-12 lg:min-w-12 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 dark:border-zinc-500 group-hover:border-gray-900 dark:group-hover:border-zinc-100 flex items-center justify-center">
                                    @include(
                                        'forum.components.svg.' .
                                            strtolower(str_replace(' ', '_', $subcategory->name)),
                                        [
                                            'class' =>
                                                'text-gray-500 dark:text-zinc-500 group-hover:text-gray-900 dark:group-hover:text-zinc-100',
                                            'w' => '55%',
                                        ]
                                    )
                                </div>

                                <h3
                                    class="text-xs xs:text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 font-bold">
                                    {{ __($subcategory->name) }}

                                </h3>
                            </div>

                            <div
                                class="ml-3 sm:ml-4 text-xs xs:text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 font-bold text-right">
                                <span
                                    class="text:xxs xs:text-xs sm:text-sm lg:text-base text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300">Постов:</span>
                                <br class="xs:hidden" /> {{ $subcategory->moderated_forum_questions_count }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
