<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | TM Insight" :header="$channel->name" :channel="$channel" noindex="true">
    <div>
        @if ($channel->banner)
            <img src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner" class="w-full aspect-[960/360] rounded-xl mb-4 lg:mb-6">
        @endif

        <div class="border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-4 lg:p-6 mb-4 lg:mb-6">
            <div class="flex items-start justify-between mb-1 sm:mb-2">
                @include('insight.components.channel', [
                    'name' => $channel->name,
                    'slug' => $channel->slug,
                    'logo' => $channel->logo,
                    'subscribers' => $channel->active_subscribers_count,
                    'sm' => true,
                ])

                <a href="{{ route('insight.channel.edit', ['channel' => $channel->slug]) }}"
                    class="text-xxs sm:text-xs lg:text-sm text-slate-500 flex items-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 cursor-pointer"
                        aria-hidden="true" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                    </svg>
                </a>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-2 lg:mb-4">
                {{ $channel->brief_description }}
            </p>

            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 whitespace-pre-line">
                {{ $channel->description }}</p>
        </div>
    </div>

    @include('insight.channel.components.menu')

    @if ($articles->count())
        <section class="mb-4 sm:mb-6 lg:mb-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                    {{ __('Delayed articles') }}
                </h2>
            </div>

            @include('insight.components.carousel', [
                'items' => $articles,
                'blade' => 'insight.article.components.card',
                'model' => 'article',
            ])
        </section>
    @endif

    @if ($posts->count())
        <section class="mb-4 sm:mb-6 lg:mb-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                    {{ __('Delayed posts') }}
                </h2>
            </div>

            @include('insight.components.carousel', [
                'items' => $posts,
                'blade' => 'insight.post.components.card',
                'model' => 'post',
            ])
        </section>
    @endif

    @if ($videos->count())
        <section class="mb-4 sm:mb-6 lg:mb-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                    {{ __('Delayed videos') }}
                </h2>
            </div>

            @include('insight.components.carousel', [
                'items' => $videos,
                'blade' => 'insight.video.components.card',
                'model' => 'video',
            ])
        </section>
    @endif

    <x-slot name="rightSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
