<div>
    @include('insight.components.comments.author-date', ['comment' => $reply])

    <div class="text-slate-600 dark:text-slate-300">
        {!! nl2br(e($reply->text)) !!}
    </div>

    @include('insight.components.comments.reactions-send_reply', [
        'comment' => $reply,
        'withoutReply' => true,
    ])
</div>
