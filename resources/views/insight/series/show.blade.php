<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | {{ $series->name }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | {{ $series->name }} | TM Insight" :header="$channel->name"
    :channel="$channel" itemtype="https://schema.org/CollectionPage" :itemname="trans_choice('insight.series', 1) . ' ' . $series->name">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/CreativeWorkSeries">
        @if ($channel->banner)
            <img itemprop="image" src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner"
                class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
        @endif

        <div
            class="border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-4 lg:p-6 mb-4 lg:mb-6">
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
                    <x-buttons.primary-button @click="$dispatch('open-modal', 'login')">
                        {{ __('Subscribe') }}
                    </x-buttons.primary-button>
                @elseif (auth()->user()->id != $channel->user_id)
                    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/FollowAction">
                        <x-buttons.primary-button itemprop="target"
                            @click="channelToggleSubscription($el, '{{ route('insight.channel.subscription', ['channel' => $channel->slug]) }}')">
                            {{ $channel->activeSubscribers()->wherePivot('user_id', auth()->user()->id)->exists()? __('Unsubscribe'): __('Subscribe') }}
                        </x-buttons.primary-button>
                    </div>
                @else
                    <a href="{{ route('insight.channel.edit', ['channel' => $channel->slug]) }}"
                        class="text-xxs sm:text-xs lg:text-sm text-slate-500 flex items-center">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 cursor-pointer"
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
                        class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line">
                        {{ $series->description }}
                    </p>
                </div>
            </div>
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
            'route' => 'insight.channel.series.content.get',
            'routeData' => ['channel' => $channel->slug, 'series' => $series->id],
        ])
    @endif

    @if ($newPosts->count())
        @include('insight.components.content', [
            'title' => 'Posts',
            'model' => 'post',
            'items' => [$newPosts, $popularPosts],
            'route' => 'insight.channel.series.content.get',
            'routeData' => ['channel' => $channel->slug, 'series' => $series->id],
        ])
    @endif

    @if ($newVideos->count())
        @include('insight.components.content', [
            'title' => 'Videos',
            'model' => 'video',
            'items' => [$newVideos, $popularVideos],
            'route' => 'insight.channel.series.content.get',
            'routeData' => ['channel' => $channel->slug, 'series' => $series->id],
        ])
    @endif
</x-insight-layout>
