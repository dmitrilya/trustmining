<x-insight-layout title="TM Insight - экспертное медиа о крипте, майнинге и оборудовании"
    description="TM Insight - ведущая медиа-платформа о криптовалютах и майнинге. Экспертные статьи, рыночная аналитика, трейдинг, оборудование и корпоративные каналы"
    header="TM Insight" itemtype="https://schema.org/WebPage" :itemname="'TM Insight ' . __('Home')">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        <section class="mb-4 sm:mb-6 lg:mb-8" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
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

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Articles') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newArticles,
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                    'endpoint' => route('insight.article.get-new')
                ])
            </div>

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'"
                x-cloak x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Articles') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularArticles,
                    'blade' => 'insight.article.components.card',
                    'model' => 'article',
                    'endpoint' => route('insight.article.get-popular')
                ])
            </div>
        </section>

        <section class="mb-4 sm:mb-6 lg:mb-8" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Posts') }}
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

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Posts') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newPosts,
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                    'endpoint' => route('insight.article.get-new')
                ])
            </div>

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'"
                x-cloak x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Posts') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularPosts,
                    'blade' => 'insight.post.components.card',
                    'model' => 'post',
                    'endpoint' => route('insight.article.get-popular')
                ])
            </div>
        </section>

        <section class="mb-4 sm:mb-6 lg:mb-8" x-data="{ tab: 'latest' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-gray-900 dark:text-gray-100">
                    {{ __('Videos') }}
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

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'latest'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Videos') . ' ' . __('New') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $newVideos,
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                    'endpoint' => route('insight.article.get-new')
                ])
            </div>

            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'"
                x-cloak x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Videos') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('insight.components.carousel', [
                    'items' => $popularVideos,
                    'blade' => 'insight.video.components.card',
                    'model' => 'video',
                    'endpoint' => route('insight.article.get-popular')
                ])
            </div>
        </section>
    </div>
</x-insight-layout>
