<div class="flex items-center justify-between">
    <p class="text-xxs sm:text-xs text-gray-500">
        {{ $content->created_at->gt(now()->subWeek()) ? $content->created_at->diffForHumans() : $content->created_at->translatedFormat('j M') }}
    </p>
    <meta itemprop="{{ $type == 'video' ? 'uploadDate' : 'datePublished' }}"
        content="{{ $content->created_at->toIso8601String() }}" />
    @if ($content->updated_at)
        <meta itemprop="dateModified" content="{{ $content->updated_at->toIso8601String() }}" />
    @endif

    <div class="ml-auto flex items-center">
        <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
            class="flex items-center" x-data="{ liked: '{{ $user && $content->likes->where('user_id', $user->id)->count() > 0 }}', likes: {{ $content->likes->count() }} }">
            <button area-label="Like"
                @if ($user) @click="if (liked) likes--; else likes++; liked = !liked; window.like('{{ $type }}', {{ $content->id }})" @else @click="$dispatch('open-modal', 'login')" @endif>
                <svg x-show="liked" aria-hidden="true" height="24" fill="currentColor" viewBox="0 0 24 24"
                    class="size-5 sm:size-6 lg:size-7 text-gray-800 dark:text-zinc-200">
                    <path fill-rule="evenodd"
                        d="M15.03 9.684h3.965c.322 0 .64.08.925.232.286.153.532.374.717.645a2.109 2.109 0 0 1 .242 1.883l-2.36 7.201c-.288.814-.48 1.355-1.884 1.355-2.072 0-4.276-.677-6.157-1.256-.472-.145-.924-.284-1.348-.404h-.115V9.478a25.485 25.485 0 0 0 4.238-5.514 1.8 1.8 0 0 1 .901-.83 1.74 1.74 0 0 1 1.21-.048c.396.13.736.397.96.757.225.36.32.788.269 1.211l-1.562 4.63ZM4.177 10H7v8a2 2 0 1 1-4 0v-6.823C3 10.527 3.527 10 4.176 10Z"
                        clip-rule="evenodd" />
                </svg>
                <svg x-show:="!liked" aria-hidden="true" width="24" height="24" fill="none"
                    viewBox="0 0 24 24"
                    class="size-5 sm:size-6 lg:size-7 text-gray-600 dark:text-zinc-400 hover:text-gray-800 dark:hover:text-gray-200">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                </svg>
            </button>

            <meta itemprop="interactionType" content="https://schema.org/LikeAction" />
            <meta itemprop="userInteractionCount" content="{{ $content->likes->count() }}" />
            <p class="text-xxs sm:text-xs text-gray-500 ml-1.5" x-text="likes"></p>
        </div>
        <div itemprop="interactionStatistic" itemscope itemtype="https://schema.org/InteractionCounter"
            class="flex items-center ml-4">
            <svg class="size-5 sm:size-6 text-gray-800 dark:text-zinc-200" aria-hidden="true" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                    clip-rule="evenodd" />
            </svg>

            <meta itemprop="interactionType" content="https://schema.org/ViewAction" />
            <p itemprop="userInteractionCount" class="text-xxs sm:text-xs text-gray-500 ml-1.5">
                {{ $content->views()->count() }}</p>
        </div>
        <div class="flex items-center ml-4">
            <button area-label="Share"
                class="text-gray-600 dark:text-zinc-400 hover:text-gray-800 dark:hover:text-gray-200"
                @click="navigator.share({
                    title: document.title,
                    url: window.location.href + '?utm_source=share_button&utm_campaign=content_propagation&utm_medium=insight&utm_content={{ $content->id }}'
                });">
                <svg class="size-5 sm:size-6 lg:size-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="m15.141 6 5.518 4.95a1.05 1.05 0 0 1 0 1.549l-5.612 5.088m-6.154-3.214v1.615a.95.95 0 0 0 1.525.845l5.108-4.251a1.1 1.1 0 0 0 0-1.646l-5.108-4.251a.95.95 0 0 0-1.525.846v1.7c-3.312 0-6 2.979-6 6.654v1.329a.7.7 0 0 0 1.344.353 5.174 5.174 0 0 1 4.652-3.191l.004-.003Z" />
                </svg>
            </button>
        </div>
    </div>

    @if ($content->series->first())
        @php
            $seriesContent = $content->series->getContent();
            $contentIndex = $seriesContent->search(
                fn($item) => $item->id === $content->id && $item->getMorphClass() === $content->getMorphClass(),
            );
            $previousContent =
                $contentIndex < $seriesContent->count() - 1 ? $seriesContent->get($contentIndex + 1) : null;
        @endphp

        @if ($previousContent)
            <x-slot name="sidebar">
                <div>
                    <p class="mb-2 sm:mb-3 lg:mb-6 text-base text-gray-700 dark:text-gray-300 font-bold ">
                        {{ __('Previous in series') }}</p>

                    @include('insight.' . $previousContent->getMorphClass() . '.components.card', [
                        $previousContent->getMorphClass() => $previousContent,
                    ])
                </div>
            </x-slot>
        @endif

        <div itemprop="isPartOf" itemscope itemtype="https://schema.org/CreativeWorkSeries">
            <meta itemprop="name" content="{{ $content->series->first()->name }}">
            <link itemprop="url"
                href="{{ route('insight.channel.series.show', ['channel' => $content->channel->slug, 'series' => $content->series->first()->id]) }}">
        </div>
    @endif
</div>
