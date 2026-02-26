<a href="{{ route('insight.channel.show', ['channel' => $slug]) }}">
    <div itemprop="author" itemscope itemtype="https://schema.org/Organization" class="flex items-center">
        <div class="min-w-6 size-6 sm:min-w-8 sm:size-8 mr-2 sm:mr-3 rounded-full border border-indigo-500 p-[0.07rem]">
            <img itemprop="logo" src="{{ Storage::url($logo) }}" alt="{{ $name }}" class="w-full rounded-full">
        </div>

        <div>
            <p itemprop="name" class="text-xs sm:text-sm text-gray-900 dark:text-gray-100 font-bold">
                {{ $name }}
            </p>

            <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
                class="flex items-center">
                <svg class="size-3.5 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                        d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                </svg>

                <meta itemprop="interactionType" content="https://schema.org/SubscribeAction" />
                <div itemprop="userInteractionCount" class="ml-1 sm:ml-2 text-xxs sm:text-xs text-gray-500">
                    {{ $subscribers }}</div>
            </div>
        </div>

        <meta itemprop="url" content="{{ route('insight.channel.show', ['channel' => $slug]) }}" />
    </div>
</a>
