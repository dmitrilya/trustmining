<x-app-layout title="Форум по майнингу и криптовалюте TrustMining: {{ $question->theme }}"
    description="Найдите ответ на вопрос среди постов или задайте свой: {{ $question->text }}">
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

            <a class="block ml-auto w-full sm:w-fit mt-3 xs:mt-4 sm:mt-5 lg:mt-0"
                href="{{ route('forum.question.create') }}">
                <x-primary-button class="w-full">
                    {{ __('New question') }}
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div
        class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 lg:py-8 lg:grid grid-cols-4 gap-3 sm:gap-5 xl:gap-7 items-start">
        <div itemscope itemtype="https://schema.org/Question" class="col-span-3 space-y-4 sm:space-y-6">
            <div
                class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 xs:p-3 md:p-4">
                <meta itemprop="about" content="{{ __($category->name) }}. {{ __($subcategory->name) }}">

                <h2 itemprop="name"
                    class="mb-2 sm:mb-4 lg:mb-6 text-sm xs:text-base sm:text-lg lg:text-xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                    {{ __($question->theme) }}
                </h2>

                @include('forum.components.author', [
                    'id' => $question->user->id,
                    'name' => $question->user->name,
                    'status' => 'Status',
                    'messages' => $question->user->moderated_forum_answers_count,
                ])

                <p itemprop="text" class="mb-1 sm:mb-3 lg:mb-5 text-xs sm:text-sm lg:text-base text-gray-500">
                    {{ $question->text }}
                </p>

                <div class="mt-3 xs:mt-4 sm:mt-5 flex justify-between">
                    <div class="flex">
                        <div class="mr-2 sm:mr-3 text-xxs sm:text-xs lg:text-sm text-gray-500 whitespace-nowrap">
                            {{ __('Views') }}: <span>{{ $question->views_count }}</span>
                        </div>
                        <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 whitespace-nowrap">
                            {{ __('Answers') }}: <span
                                itemprop="answerCount">{{ $question->moderatedForumAnswers->count() }}</span>
                        </div>
                    </div>
                    <div>
                        <div data-type="datetime" data-date="{{ $question->created_at }}"
                            class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500"></div>
                        <meta itemprop="dateCreated" content="{{ $question->created_at }}">
                    </div>
                </div>
            </div>

            @foreach ($question->moderatedForumAnswers as $i => $answer)
                @include('forum.answer.show')
            @endforeach

            <div
                class="bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg dark:border dark:border-zinc-700">
                @if (!Auth::user())
                    <div class="flex flex-col items-center justify-center w-full h-full p-2 sm:p-4 lg:p-6">
                        <p class="mb-3 sm:mb-5 text-gray-700 dark:text-gray-300 text-xs sm:text-sm lg:text-base">
                            {{ __('Please log in to leave a reply') }}</p>
                        <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                    </div>
                @else
                    @include('forum.answer.create')
                @endif
            </div>
        </div>

        @include('forum.components.sidebar')
    </div>
</x-app-layout>
