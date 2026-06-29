<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | TM Insight" :header="$channel->name" :channel="$channel"
    itemtype="https://schema.org/ProfilePage" :itemname="__('Channel') . ' ' . $channel->name">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/Organization">
        @if ($channel->banner)
            <img itemprop="image" src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner"
                class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
        @endif

        <div
            class="border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-4 lg:p-6 mb-4 lg:mb-6">
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
                    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/FollowAction">
                        <x-primary-button itemprop="target"
                            @click="channelToggleSubscription($el, '{{ route('insight.channel.subscription', ['channel' => $channel->slug]) }}')">
                            {{ $channel->activeSubscribers()->wherePivot('user_id', auth()->user()->id)->exists()? __('Unsubscribe'): __('Subscribe') }}
                        </x-primary-button>
                    </div>
                @else
                    <a href="{{ route('insight.channel.edit', ['channel' => $channel->slug]) }}"
                        class="text-xxs sm:text-xs lg:text-sm text-slate-500 flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 cursor-pointer"
                            aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                    </a>
                @endif
            </div>

            <p class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 mb-2 lg:mb-4">
                {{ $channel->brief_description }}
            </p>

            <p itemprop="description" class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line">
                {{ $channel->description }}</p>
        </div>
    </div>

    @if (auth()->check() && auth()->user()->id == $channel->user_id)
        @include('insight.channel.components.menu')
    @endif

    @if ($newArticles->count())
        @include('insight.components.content', [
            'title' => 'Articles',
            'model' => 'article',
            'items' => [$newArticles, $popularArticles],
            'route' => 'insight.channel.content.get',
            'routeData' => ['channel' => $channel->slug],
        ])
    @endif

    @if ($newPosts->count())
        @include('insight.components.content', [
            'title' => 'Posts',
            'model' => 'post',
            'items' => [$newPosts, $popularPosts],
            'route' => 'insight.channel.content.get',
            'routeData' => ['channel' => $channel->slug],
        ])
    @endif

    @if ($newVideos->count())
        @include('insight.components.content', [
            'title' => 'Videos',
            'model' => 'video',
            'items' => [$newVideos, $popularVideos],
            'route' => 'insight.channel.content.get',
            'routeData' => ['channel' => $channel->slug],
        ])
    @endif

    @if ($series->where('contents_count', '>', 0)->count())
        <section itemscope itemtype="https://schema.org/ItemList">
            <h2 itemprop="name"
                class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100 px-4 py-1.5 lg:px-5 w-fit mb-2 sm:mb-3">
                {{ trans_choice('insight.series', 2) }}</h2>
            <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

            @include('insight.components.carousel', [
                'items' => $series->where('contents_count', '>', 0),
                'blade' => 'insight.series.components.card',
                'model' => 'series',
            ])
        </section>
    @endif
</x-insight-layout>
