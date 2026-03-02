<div class="flex justify-between mb-2">
    <div class="flex">
        @php
            $logo = !$comment->user->channel
                ? ($comment->user->company
                    ? $comment->user->company->logo
                    : null)
                : $comment->user->channel->logo;
            $name = $comment->user->channel ? $comment->user->channel->name : $comment->user->name;
        @endphp

        @if ($logo)
            <div class="min-w-6 size-6 sm:min-w-8 sm:size-8 mr-2 sm:mr-3 rounded-full border border-indigo-500 p-0.5">
                <img itemprop="image" src="{{ Storage::url($logo) }}" alt="{{ 'logo_' . $name }}"
                    class="w-full rounded-full">
            </div>
        @endif

        <div class="font-medium text-sm text-slate-800 dark:text-slate-200">
            {{ $name }}
        </div>
    </div>

    <div class="text-xs text-slate-500">
        {{ $comment->created_at->diffForHumans() }}
    </div>
</div>
