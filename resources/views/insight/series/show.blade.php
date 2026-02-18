<x-insight-layout title="{{ $channel->name }} - {{ $channel->brief_description }} | TM Insight"
    description="{{ $channel->name }} - {{ $channel->description }} | TM Insight" :header="$channel->name . ' / ' . $series->name" :channel="$channel">
    @if ($channel->banner)
        <img src="{{ Storage::url($channel->banner) }}" alt="{{ $channel->name }} banner"
            class="w-full aspect-[960/360] rounded-lg mb-4 lg:mb-6">
    @endif

    @if (auth()->user()->id == $channel->user_id)
        @include('insight.channel.components.menu')
    @endif

    @if ($articles->count())
        <section class="mb-4 lg:mb-6" x-data="{ tab: 'latest' }">
            <div
                class="flex items-center justify-between bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color rounded-full px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
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
                    'items' => $articles->sortBy('views_count'),
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                ])
            </div>
        </section>
    @endif

    @if ($posts->count())
        <section class="my-4 lg:my-6" x-data="{ tab: 'latest' }">
            <div
                class="flex items-center justify-between bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color rounded-full px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
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
</x-insight-layout>
