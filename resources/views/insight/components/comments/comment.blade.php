<div data-comment_id="{{ $comment->id }}"
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color p-2 sm:p-4 lg:p-6 rounded-xl shadow-sm">
    @include('insight.components.comments.author-date')

    <div class="text-sm text-slate-700 dark:text-slate-300 mb-3">
        {!! nl2br(e($comment->text)) !!}
    </div>

    <div x-data="{
        showReply: false,
    }" class="text-xs text-slate-500">
        @include('insight.components.comments.reactions-send_reply')

        @if ($comment->replies->count())
            @include('insight.components.comments.replies')
        @endif
    </div>
</div>
