<div itemprop="comment" itemscope itemtype="https://schema.org/Comment" class="flex justify-between">
    @include('forum.components.author', [
        'id' => $comment->user->id,
        'name' => $comment->user->name,
        'status' => 'Status',
        'messages' => $comment->user->moderated_forum_answers_count,
        'sm' => true
    ])

    <p itemprop="text" class="text-xs lg:text-sm text-gray-500 dark:text-gray-400">
        {{ $comment->text }}
    </p>

    <div class="text-right ml-3 sm:ml-5">
        <div data-type="datetime" data-date="{{ $question->created_at }}"
            class="date-transform text-xxs xs:text-xs lg:text-sm text-gray-500">
        </div>
        <meta itemprop="dateCreated" content="{{ $question->created_at }}">
    </div>
</div>
