<a href="{{ route('insight.channel.show', ['channel' => $channel->slug]) }}" class="hover:opacity-80">
    <div class="flex flex-col items-center">
        <div
            class="mb-2 min-w-16 size-16 sm:min-w-22 sm:size-22 rounded-full border border-indigo-500 p-0.5">
            <img src="{{ Storage::url($channel->logo) }}" alt="{{ $channel->name }}" class="w-full rounded-full">
        </div>

        <p class="mb-0.5 sm:mb-1 lg:text-sm text-xs text-gray-900 dark:text-gray-100 font-bold">
            {{ $channel->name }}</p>

        <div class="mb-0.5 sm:mb-1 text-xxs xs:text-xs lg:text-sm text-gray-500">
            {{ '@' . $channel->slug }}</div>

        <div class="flex items-center">
            <svg class="size-4 sm:size-5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                    d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
            </svg>

            <div class="ml-1 sm:ml-2 text-xxs xs:text-xs lg:text-sm text-gray-500">
                {{ $channel->active_subscribers_count }}</div>
        </div>
    </div>
</a>
