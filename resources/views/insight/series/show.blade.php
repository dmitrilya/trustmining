<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | TM Insight" :header="$channel->name" :channel="$channel"
    itemtype="https://schema.org/CollectionPage" :itemname="trans_choice('insight.series', 1) . ' ' . $series->name">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/CreativeWorkSeries">
        @if ($channel->banner)
            <img itemprop="image" src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner"
                class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
        @endif

        <div
            class="border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-xl p-4 lg:p-6 mb-4 lg:mb-6">
            <div itemprop="author" itemscope itemtype="https://schema.org/Organization"
                class="flex items-start justify-between mb-1 sm:mb-2">
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
                    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/FollowAction">
                        <x-primary-button itemprop="target"
                            @click="channelToggleSubscription($el, '{{ route('insight.channel.subscription', ['channel' => $channel->slug]) }}')">
                            {{ $channel->activeSubscribers()->wherePivot('user_id', auth()->user()->id)->exists()? __('Unsubscribe'): __('Subscribe') }}
                        </x-primary-button>
                    </div>
                @else
                    <a href="{{ route('insight.channel.edit', ['channel' => $channel->slug]) }}"
                        class="text-xxs sm:text-xs lg:text-sm text-slate-500 flex items-center">
                        <svg class="size-5 sm:size-6 lg:size-7 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer"
                            aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="flex">
                <img itemprop="image" src="{{ Storage::url($series->getContent()->first()?->preview) }}"
                    alt="{{ $series->name }} preview" class="h-20 rounded-xl mr-4 lg:mr-6">

                <div>
                    <p itemprop="name" class="text-base sm:text-lg lg:text-xl text-slate-800 dark:text-slate-200">
                        {{ $series->name }}
                    </p>

                    <p itemprop="description"
                        class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line">{{ $series->description }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->check() && auth()->user()->id == $channel->user_id)
        @include('insight.channel.components.menu')
    @endif

    @if ($newArticles->count())
        <section class="mb-4 lg:mb-6" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Articles') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Articles') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newArticles,
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                    'endpoint' => route('insight.channel.series.article.get-new', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Articles') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularArticles,
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                    'endpoint' => route('insight.channel.series.article.get-popular', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>
        </section>
    @endif

    @if ($newPosts->count())
        <section class="my-4 lg:my-6" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Posts') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Posts') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newPosts,
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                    'endpoint' => route('insight.channel.series.post.get-new', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Posts') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularPosts,
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                    'endpoint' => route('insight.channel.series.post.get-popular', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>
        </section>
    @endif

    @if ($newVideos->count())
        <section class="my-4 lg:my-6" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Videos') }}
                </h2>

                <div class="flex text-xs sm:text-sm font-medium">
                    <button @click="tab = 'latest'"
                        :class="tab === 'latest' ? 'bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('New') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ? 'bg-white dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Videos') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newVideos,
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                    'endpoint' => route('insight.channel.series.video.get-new', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Videos') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularVideos,
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                    'endpoint' => route('insight.channel.series.video.get-popular', ['channel' => $channel->slug, 'series' => $series->id])
                ])
            </div>
        </section>
    @endif
</x-insight-layout>
