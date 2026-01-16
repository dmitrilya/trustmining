<div itemprop="comment" itemscope itemtype="https://schema.org/Comment" x-data="open: false">
    <div class="flex justify-between">
        @include('forum.components.author', [
            'id' => $comment->user->id,
            'name' => $comment->user->name,
            'status' => 'Status',
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

    @if ($comment->images)
        <div class="mb-2 sm:mb-3 lg:mb-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-2 xs:gap-3 xl:gap-4">
            @foreach ($comment->images as $image)
                <div class="group relative rounded-lg overflow-hidden flex items-center overflow-hidden cursor-zoom-in">
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
