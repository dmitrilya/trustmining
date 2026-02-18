<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | TM Insight" :header="$channel->name" :channel="$channel">
    @if ($channel->banner)
        <img src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner"
            class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
    @endif

    <div class="border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6 mb-4 lg:mb-6">
        <div class="flex items-start justify-between mb-1 sm:mb-2">
            @include('insight.components.channel', [
                'name' => $channel->name,
                'slug' => $channel->slug,
                'logo' => $channel->logo,
                'subscribers' => $channel->active_subscribers_count,
                'sm' => true,
            ])

            @if (!auth()->check())
                <x-primary-button @click="$dispatch('open-modal', 'login')">
                    {{ __('Subscribe') }}
                </x-primary-button>
            @elseif (auth()->user()->id != $channel->user_id)
                <x-primary-button
                    @click="channelToggleSubscription($el, '{{ route('insight.channel.subscription', ['channel' => $channel->slug]) }}')">
                    {{ $channel->activeSubscribers()->wherePivot('user_id', auth()->user()->id)->exists()? __('Unsubscribe'): __('Subscribe') }}
                </x-primary-button>
            @endif
        </div>

        <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 mb-2 lg:mb-4">{{ $channel->brief_description }}</p>

        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $channel->description }}</p>
    </div>

    @if (auth()->check() && auth()->user()->id == $channel->user_id)
        @include('insight.channel.components.menu')
    @endif

    @if ($articles->count())
        <section class="mb-4 lg:mb-6" x-data="{ tab: 'latest' }">
            <div
                class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Articles') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-gray-100 dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-gray-100 dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div x-show="tab === 'latest'" x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $articles->sortByDesc('created_at'),
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                ])
            </div>

            <div x-show="tab === 'popular'" x-cloak x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $articles->sortByDesc('views_count'),
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                ])
            </div>
        </section>
    @endif

    @if ($posts->count())
        <section class="my-4 lg:my-6" x-data="{ tab: 'latest' }">
            <div
                class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Posts') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-white dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-white dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div x-show="tab === 'latest'" x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $posts->sortByDesc('created_at'),
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                ])
            </div>

            <div x-show="tab === 'popular'" x-cloak x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $posts->sortByDesc('views_count'),
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                ])
            </div>
        </section>
    @endif

    @if ($videos->count())
        <section class="my-4 lg:my-6" x-data="{ tab: 'latest' }">
            <div
                class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Videos') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-white dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-white dark:bg-zinc-800 shadow-sm text-gray-700 dark:text-gray-300' :
                            'text-gray-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div x-show="tab === 'latest'" x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $videos->sortByDesc('created_at'),
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                ])
            </div>

            <div x-show="tab === 'popular'" x-cloak x-transition:enter.duration.400ms>
                @include('insight.components.carousel', [
                    'items' => $videos->sortByDesc('views_count'),
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                ])
            </div>
        </section>
    @endif

    @if ($series->where('contents_count', '>', 0)->count())
        <section>
            <h2
                class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100 px-4 py-1.5 lg:px-5 w-fit mb-2 sm:mb-3">
                {{ trans_choice('all.series', 2) }}</h2>

            @include('insight.components.carousel', [
                'items' => $series,
                'blade' => 'insight.series.components.card',
                'model' => 'series',
            ])
        </section>
    @endif
</x-insight-layout>
