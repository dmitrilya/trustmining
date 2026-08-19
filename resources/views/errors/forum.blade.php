<x-app-layout noindex="true" :title='__("errors.forum.$code.question.title")'>
    <x-slot name="header">
        <div class="lg:flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol role="list" class="flex items-center sm:space-x-2">
                    <li class="text-sm">
                        <div class="flex items-center">
                            <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                                <span>{{ __('Forum') }}</span>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex justify-end mt-2 xs:mt-4 lg:mt-0">
                <a class="mr-1 xs:mr-2" href="{{ route('forum.question.mine') }}">
                    <x-buttons.secondary-button class="bg-secondary-gradient dark:text-slate-800">{{ __('My questions') }}</x-buttons.secondary-button>
                </a>
                <a href="{{ route('forum.question.create') }}">
                    <x-buttons.primary-button>
                        {{ __('New question') }}
                    </x-buttons.primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $authId = null;
        $user = null;
        $ranks = config('forum.ranks');
        $answerPoints = config('forum.answer');
        $helpfulAnswerPoints = config('forum.like');
        $bestAnswerPoints = config('forum.best');
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 lg:py-8 lg:grid grid-cols-4 gap-2 sm:gap-4 items-start">
        <div class="col-span-3 space-y-2 sm:space-y-4">
            <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-sm shadow-logo-color rounded-xl p-2 xs:p-3 md:p-4"
                x-data="{ open: false }">

                <h1 class="mb-2 sm:mb-4 lg:mb-6 text-sm xs:text-base sm:text-lg lg:text-xl text-slate-800 dark:text-slate-200 font-bold">
                    {{ __("errors.forum.$code.question.title") }}
                </h1>

                @include('forum.components.author', [
                    'id' => 1,
                    'name' => __("errors.forum.$code.question.author"),
                    'forumScore' => $code,
                    'messages' => $code,
                ])

                <div class="mb-2 sm:mb-3 lg:mb-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2 xs:gap-3 xl:gap-4">
                    <div class="group relative rounded-lg overflow-hidden flex items-center overflow-hidden cursor-zoom-in">
                        <div @click.self="$refs.image_preview.src = $el.nextElementSibling.src; open = true"
                            class="absolute w-full h-full bg-slate-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                        </div>
                        <img src="/img/errors/{{ $code }}.webp" alt="error {{ $code }}" />
                    </div>
                </div>

                <div class="mb-1 sm:mb-3 lg:mb-6 text-xs sm:text-sm lg:text-base text-slate-600 dark:text-slate-400 whitespace-pre-line">
                    {{ __("errors.forum.$code.question.text") }}</div>

                <div class="mt-3 xs:mt-4 sm:mt-5">
                    <div class="flex">
                        <div class="mr-2 sm:mr-3 text-xxs sm:text-xs lg:text-sm text-slate-500 whitespace-nowrap">
                            {{ __('Views') }}: <span>{{ $code }}</span>
                        </div>
                        <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-slate-500 whitespace-nowrap">
                            {{ __('Answers') }}: <span>{{ $code }}</span>
                        </div>
                    </div>
                </div>

                <div style="display: none" x-show="open" tabindex="-1" aria-hidden="true"
                    class="overflow-y-auto overflow-x-hidden flex justify-center items-center fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="bg-slate-900/50 dark:bg-slate-950/80 fixed inset-0 z-40"></div>
                    <div class="relative p-2 sm:p-4 flex items-center justify-center w-full max-w-2xl h-full max-w-max max-h-full z-50">
                        <div class="relative place-items-center bg-white rounded-xl overflow-hidden shadow h-full max-h-max dark:bg-slate-800"
                            @click.away="open = false">
                            <button @click="open = false" type="button"
                                class="absolute top-1 right-1 text-slate-600 bg-transparent hover:text-slate-600 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-slate-700 dark:hover:text-slate-200">
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <img x-ref="image_preview" src="" alt="Image preview" class="max-h-full">
                        </div>
                    </div>
                </div>
            </div>

            @php
                $fakeAnswer = new \App\Models\Forum\ForumAnswer([
                    'text' => __("errors.forum.$code.answer_1.text"),
                    'images' => [],
                    'files' => [],
                ]);
                $fakeAnswer->id = 0;
                $fakeAnswer->likes_count = $code;
                $fakeAnswer->created_at = now();

                $fakeUser = new \App\Models\User\User([
                    'name' => 'Trust Mining Developers',
                ]);
                $fakeUser->id = 0;
                $fakeUser->forum_score = $code;
                $fakeUser->moderated_forum_answers_count = $code;

                $fakeAnswer->setRelation('user', $fakeUser);

                $fakeUser = new \App\Models\User\User([
                    'name' => __("errors.forum.$code.comment.author"),
                ]);
                $fakeUser->id = 1;
                $fakeUser->forum_score = $code;
                $fakeUser->moderated_forum_answers_count = $code;

                $fakeComment = new \App\Models\Forum\ForumComment([
                    'text' => __("errors.forum.$code.comment.text"),
                    'images' => [],
                    'files' => [],
                ]);
                $fakeComment->id = 0;
                $fakeComment->likes_count = $code;
                $fakeComment->created_at = now();

                $fakeComment->setRelation('user', $fakeUser);

                $fakeAnswer->setRelation('moderatedForumComments', collect([$fakeComment]));
            @endphp

            @include('forum.answer.show', ['answer' => $fakeAnswer, 'i' => 0])

            @php
                $fakeAnswer = new \App\Models\Forum\ForumAnswer([
                    'text' => __("errors.forum.$code.answer_2.text"),
                    'images' => [],
                    'files' => [],
                ]);
                $fakeAnswer->id = 0;
                $fakeAnswer->likes_count = $code;
                $fakeAnswer->created_at = now();

                $fakeUser = new \App\Models\User\User([
                    'name' => __("errors.forum.$code.answer_2.author"),
                ]);
                $fakeUser->id = 1;
                $fakeUser->forum_score = $code;
                $fakeUser->moderated_forum_answers_count = $code;

                $fakeAnswer->setRelation('user', $fakeUser);

                $fakeAnswer->setRelation('moderatedForumComments', collect());
            @endphp

            @include('forum.answer.show', ['answer' => $fakeAnswer, 'i' => 1])
        </div>

        @include('forum.components.sidebar', [
            'newQuestions' => App\Models\Forum\ForumQuestion::where('published', true)->select(['id', 'forum_subcategory_id', 'theme'])->with(['forumSubcategory:id,name,slug,forum_category_id', 'forumSubcategory.forumCategory:id,name,slug'])->latest()->limit(5)->get(),
        ])
    </div>
</x-app-layout>
