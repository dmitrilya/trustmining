<div
    class="p-2 sm:p-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl">
    <h2 class="text-xs text-slate-500 uppercase tracking-widest mb-4 lg:mb-6">
        {{ __('Top channels') }}
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-1 gap-4">
        @foreach ($topChannels as $channel)
            @include('insight.components.channel-col')
        @endforeach
    </div>
</div>
