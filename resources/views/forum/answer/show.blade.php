<div itemprop="{{ $i == 0 && $answer->likes_count ? 'acceptedAnswer' : 'suggestedAnswer' }}" itemscope
    itemtype="https://schema.org/Answer" x-data="{ open: false }" id="answer-{{ $answer->id }}"
    class="bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg p-2 xs:p-3 md:p-4">
    <div class="mb-2 sm:mb-4 lg:mb-6 flex justify-between">
        @if ($i == 0 && $answer->likes_count)
            <svg class="flex-shrink-0 size-5 sm:size-7 text-yellow-300" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                    clip-rule="evenodd" />
            </svg>
        @endif

        <div class="ml-auto flex items-end">
            @if ($authId && $authId == $answer->user_id)
                <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
                    @click="forumEdit($refs.content)">
                    <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                        aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                    </svg>
                </div>

                <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
                    @click="deleteHref = '{{ route('forum.answer.destroy', ['forumAnswer' => $answer->id]) }}'; $dispatch('open-modal', 'delete-modal')">
                    <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="24" fill="none"
                        viewBox="0 0 26 26">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" height="18.67px"
                            stroke-width="1.5"
                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                    </svg>
                </div>
            @else
                <div class="text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center" x-data="{ liked: '{{ $user && $answer->likes->where('user_id', $user->id)->count() }}', likes: {{ $answer->likes_count }} }">
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
                        aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                    </svg>
                    <span class="ml-1 sm:ml-1.5" x-text="likes"></span>
                    <meta itemprop="upvoteCount" content="{{ $answer->likes_count }}">
                </div>
            @endif
        </div>
    </div>

    @include('forum.components.author', [
        'id' => $answer->user->id,
        'name' => $answer->user->name,
        'forumScore' => $answer->user->forum_score,
        'messages' => $answer->user->moderated_forum_answers_count,
    ])

    <div x-ref="content">
        @if ($answer->images)
            <div class="mb-2 sm:mb-3 lg:mb-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2 xs:gap-3 xl:gap-4">
                @foreach ($answer->images as $image)
                    <div
                        class="group relative rounded-lg overflow-hidden flex items-center overflow-hidden cursor-zoom-in">
                        <div @click.self="$refs.image_preview.src = $el.nextElementSibling.src; open = true"
                            class="absolute w-full h-full bg-gray-900/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                        </div>
                        <img src="{{ Storage::url($image) }}" />
                    </div>
                @endforeach
            </div>
        @endif

        <div itemprop="text" class="mb-1 sm:mb-3 text-xs sm:text-sm lg:text-base text-gray-500">
            {!! $answer->text !!}
        </div>
    </div>

    <div class="hidden">
        @include('forum.answer.edit')
    </div>

    <div class="ml-auto w-fit mb-2 sm:mb-3 lg:mb-4">
        <div data-type="datetime" data-date="{{ $answer->created_at }}"
            class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500"></div>
        <meta itemprop="dateCreated" content="{{ $answer->created_at }}">
    </div>

    <div x-data="{ show: false }" class="px-2 sm:px-4 h-full border-t border-gray-200 dark:border-zinc-700">
        <div>
            <h3 id="accordion-flush-themes-heading">
                <button type="button" @click="show = !show"
                    class="flex items-center justify-between w-full py-5 text-left rtl:text-right text-gray-800 dark:text-gray-200 text-xs sm:text-sm lg:text-base">
                    <span>{{ __('Comments') }} ({{ $answer->moderatedForumComments->count() }})</span>
                    <svg class="w-3 h-3 shrink-0" :class="{ 'rotate-180': !show }" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
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
                            @include('forum.comment.show')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none" x-show="open" tabindex="-1" aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden flex justify-center items-center fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="bg-gray-900/50 dark:bg-zinc-950/80 fixed inset-0 z-40"></div>
        <div
            class="relative p-2 sm:p-4 flex items-center justify-center w-full max-w-2xl h-full max-w-max max-h-full z-50">
            <div class="relative place-items-center bg-white rounded-xl overflow-hidden shadow h-full max-h-max dark:bg-zinc-800"
                @click.away="open = false">
                <button @click="open = false" type="button"
                    class="absolute top-1 right-1 text-gray-600 bg-transparent hover:text-gray-600 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-zinc-700 dark:hover:text-white">
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
