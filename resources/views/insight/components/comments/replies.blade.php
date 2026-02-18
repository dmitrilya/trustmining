<div x-data="{ showReplies: false }" class="mt-2 sm:mt-3">
    @if ($comment->replies->count())
        <button @click="showReplies = !showReplies" class="hover:text-indigo-600 transition-colors" :class="showReplies ? 'text-indigo-600' : ''">
            {{ $comment->replies->count() }} {{ trans_choice('insight.replies', $comment->replies->count()) }}
        </button>
    @endif

    <div x-show="showReplies" x-transition class="replies-container mt-4 space-y-4 lg:space-y-5 border-l pl-4 border-gray-200 dark:border-zinc-700">
        @foreach ($comment->replies as $reply)
            @include('insight.components.comments.reply')
        @endforeach
    </div>
</div>
