<div
    class="p-4 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden shadow shadow-logo-color rounded-xl">
    <h2 class="mb-4 lg:mb-6 text-base text-gray-700 dark:text-gray-300 font-bold">
        {{ __('Top channels') }}
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-1 gap-4">
        @foreach ($topChannels as $channel)
            @include('insight.components.channel-col')
        @endforeach
    </div>
</div>
