<div class="p-1.5 space-y-1">
    <a href="{{ route('insight.article.create', ['channel' => auth()->user()->channel->slug]) }}"
        class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors group/item">
        <span class="p-1 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600">📝</span>
        <div class="flex flex-col">
            <span class="font-medium">{{ __('Article') }}</span>
            <span class="text-[10px] text-slate-500">{{ __('Long read content') }}</span>
        </div>
    </a>

    <a href="{{ route('insight.post.create', ['channel' => auth()->user()->channel->slug]) }}"
        class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors group/item">
        <span class="p-1 rounded-lg bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600">💬</span>
        <div class="flex flex-col">
            <span class="font-medium">{{ __('Post') }}</span>
            <span class="text-[10px] text-slate-500">{{ __('Short thoughts') }}</span>
        </div>
    </a>

    <a href="{{ route('insight.video.create', ['channel' => auth()->user()->channel->slug]) }}"
        class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors group/item">
        <span class="p-1 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-amber-600">🎥</span>
        <div class="flex flex-col">
            <span class="font-medium">{{ __('Video') }}</span>
            <span class="text-[10px] text-slate-500">{{ __('Visual stories') }}</span>
        </div>
    </a>
</div>
