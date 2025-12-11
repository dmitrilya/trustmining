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
                <div itemprop="{{ $i == 0 && $answer->likes_count ? 'acceptedAnswer' : 'suggestedAnswer' }}" itemscope
                    itemtype="https://schema.org/Answer"
                    class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 xs:p-3 md:p-4">
                    <div class="mb-2 sm:mb-4 lg:mb-6 flex justify-between">
                        @if ($i == 0 && $answer->likes_count)
                            <svg class="flex-shrink-0 size-5 sm:size-7 text-yellow-300" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                    clip-rule="evenodd" />
                            </svg>
                        @endif

                        <div class="ml-auto text-right">
                            <div class="text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
                                x-data="{ liked: '{{ $user && $answer->likes->where('user_id', $user->id)->count() }}', likes: {{ $answer->likes_count }} }">
                                <svg x-show="liked"
                                    @if ($user) @click="liked = false; likes--; window.like('Forum\\ForumAnswer', {{ $answer->id }})" @endif
                                    class="size-5 sm:size-6 lg:size-7 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 cursor-pointer"
                                    aria-hidden="true" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <svg x-show="!liked"
                                    @if ($user) @click="liked = true; likes++; window.like('Forum\\ForumAnswer', {{ $answer->id }})" @endif
                                    class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                                    aria-hidden="true" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                                </svg>
                                <span class="ml-1 sm:ml-1.5" x-text="likes"></span>
                                <meta itemprop="upvoteCount" content="{{ $answer->likes_count }}">
                            </div>
                        </div>
                    </div>

                    @include('forum.components.author', [
                        'id' => $answer->user->id,
                        'name' => $answer->user->name,
                        'status' => 'Status',
                        'messages' => $answer->user->moderated_forum_answers_count,
                    ])

                    <p itemprop="text" class="mb-1 sm:mb-3 lg:mb-5 text-xs sm:text-sm lg:text-base text-gray-500">
                        {{ $answer->text }}
                    </p>

                    <div x-data="{ show: false }"
                        class="px-2 sm:px-4 h-full border-t border-gray-200 dark:border-zinc-700">
                        <div>
                            <h3 id="accordion-flush-themes-heading">
                                <button type="button" @click="show = !show"
                                    class="flex items-center justify-between w-full py-5 text-left rtl:text-right text-gray-800 dark:text-gray-200 text-xs sm:text-sm lg:text-base">
                                    <span>{{ __('Comments') }} ({{ $answer->moderatedForumComments->count() }})</span>
                                    <svg class="w-3 h-3 shrink-0" :class="{ 'rotate-180': !show }" fill="none"
                                        viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h3>
                            <div x-show="show" style="display: none">
                                <div class="py-3">
                                    @if (!Auth::user())
                                        <div class="flex items-center justify-center w-full h-full">
                                            <a
                                                href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                                        </div>
                                    @else
                                        @include('forum.comment.create')
                                    @endif

                                    <div class="mt-4 sm:mt-6 lg:mt-8 space-y-2 sm:space-y-4">
                                        @foreach ($answer->moderatedForumComments as $comment)
                                            <div itemprop="comment" itemscope itemtype="https://schema.org/Comment" itemref="comment_{{ $comment->id }}"
                                                class="flex justify-between">
                                                <div itemprop="author" itemscope itemtype="https://schema.org/Person"
                                                    class="flex">
                                                    <div
                                                        class="size-8 sm:size-10 lg:size-12 mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5 overflow-hidden">
                                                        <img itemprop="image"
                                                            src="{{ Storage::url('public/forum/avatar_' . $comment->user->id . '.webp') }}"
                                                            alt="{{ $comment->user->name }}"
                                                            class="w-full rounded-full">
                                                    </div>

                                                    <div>
                                                        <h5 itemprop="name"
                                                            class="mb-0.5 sm:mb-1 text-xs lg:text-sm text-gray-700 dark:text-gray-300">
                                                            {{ $comment->user->name }}
                                                        </h5>
                                                        <p itemprop="text" id="comment_{{ $comment->id }}"
                                                            class="text-xs lg:text-sm text-gray-500 dark:text-gray-400">
                                                            {{ $comment->text }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="text-right ml-3 sm:ml-5">
                                                    <div data-type="datetime" data-date="{{ $question->created_at }}"
                                                        class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500">
                                                    </div>
                                                    <meta itemprop="dateCreated"
                                                        content="{{ $question->created_at }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ml-auto w-fit">
                        <div data-type="datetime" data-date="{{ $answer->created_at }}"
                            class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500"></div>
                        <meta itemprop="dateCreated" content="{{ $answer->created_at }}">
                    </div>
                </div>
            @endforeach

            <div
                class="bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg dark:border dark:border-zinc-700">
                @if (!Auth::user())
                    <div class="flex items-center justify-center w-full h-full">
                        <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                    </div>
                @else
                    @include('forum.answer.create')
                @endif
            </div>
        </div>

        <div class="w-full mt-4 sm:mt-6 lg:mt-0 space-y-4 sm:space-y-6 col-span-1">
            <div class="w-full bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg">
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
                                'forumQuestion' => $similarQuestion->id . '-' . mb_strtolower(str_replace(' ', '-', $similarQuestion->theme)),
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

            <div class="w-full bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg">
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
                                'forumQuestion' => $newQuestion->id . '-' . mb_strtolower(str_replace(' ', '-', $newQuestion->theme)),
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
    </div>
</x-app-layout>
