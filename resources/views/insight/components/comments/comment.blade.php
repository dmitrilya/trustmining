<div data-comment_id="{{ $comment->id }}"
    class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color p-2 sm:p-4 lg:p-6 rounded-xl shadow-sm">
    @include('insight.components.comments.author-date')

    <div class="text-sm text-gray-700 dark:text-gray-300 mb-3">
        {!! nl2br(e($comment->text)) !!}
    </div>

    <div x-data="{
        showReply: false,
    }" class="text-xs text-gray-500">
        @include('insight.components.comments.reactions-send_reply')

        @if ($comment->replies->count())
            @include('insight.components.comments.replies')
        @endif
    </div>
</div>
