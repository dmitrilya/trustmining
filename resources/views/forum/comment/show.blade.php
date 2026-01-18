<div itemprop="comment" itemscope itemtype="https://schema.org/Comment" x-data="{ open: false }">
    @if ($authId && $authId == $answer->user_id)
        <div class="flex justify-end items-center mb-2 sm:mb-3">
            <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
                @click="forumEdit($refs.comment_content)">
                <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                    aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                </svg>
            </div>

            <div class="mr-2 text-xxs sm:text-xs lg:text-sm text-gray-500 flex items-center"
                @click="deleteHref = '{{ route('forum.comment.destroy', ['forumComment' => $comment->id]) }}'; $dispatch('open-modal', 'delete-modal')">
                <svg class="size-5 sm:size-6 lg:size-7 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 cursor-pointer"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" height="24" fill="none"
                    viewBox="0 0 26 26">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" height="18.67px"
                        stroke-width="1.5"
                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                </svg>
            </div>
        </div>
    @endif

    <div class="flex justify-between">
        @include('forum.components.author', [
            'id' => $comment->user->id,
            'name' => $comment->user->name,
            'forumScore' => $comment->user->forum_score,
            'messages' => $comment->user->moderated_forum_answers_count,
            'sm' => true,
        ])

        <div class="text-right ml-3 sm:ml-5">
            <div data-type="datetime" data-date="{{ $comment->created_at }}"
                class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500">
            </div>
            <meta itemprop="dateCreated" content="{{ $comment->created_at }}">
        </div>
    </div>

    <div x-ref="comment_content">
        @if ($comment->images)
            <div class="mb-2 sm:mb-3 lg:mb-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2 xs:gap-3 xl:gap-4">
                @foreach ($comment->images as $image)
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

        <div itemprop="text" class="text-xs lg:text-sm text-gray-500 dark:text-gray-400">
            {!! $comment->text !!}
        </div>
    </div>

    <div class="hidden">
        @include('forum.comment.edit')
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
