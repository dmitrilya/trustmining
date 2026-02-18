<div>
    @include('insight.components.comments.author-date', ['comment' => $reply])

    <div class="text-gray-600 dark:text-gray-300">
        {!! nl2br(e($reply->text)) !!}
    </div>

    @include('insight.components.comments.reactions-send_reply', [
        'comment' => $reply,
        'withoutReply' => true,
    ])
</div>
