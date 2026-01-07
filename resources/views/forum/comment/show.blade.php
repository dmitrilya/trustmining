<div itemprop="comment" itemscope itemtype="https://schema.org/Comment">
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
                <div class="rounded-lg overflow-hidden">
                    <img src="{{ Storage::url($image) }}" alt="">
                </div>
            @endforeach
        </div>
    @endif

    <p itemprop="text" class="text-xs lg:text-sm text-gray-500 dark:text-gray-400 whitespace-pre-line">
        {{ $comment->text }}
    </p>
</div>
