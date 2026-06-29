<section class="mb-4 sm:mb-6 lg:mb-8" x-data="{ tab: 'new' }">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
            {{ __($title) }}
        </h2>

        <div class="flex text-xs s m:text-sm">
            <button @click="tab = 'new'"
                :class="tab === 'new' ?
                    'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                    'text-slate-500'"
                class="px-3 py-1 rounded-full transition-all">
                {{ __('New') }}
            </button>
            <button @click="tab = 'popular'"
                :class="tab === 'popular' ?
                    'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                    'text-slate-500'"
                class="px-3 py-1 rounded-full transition-all">
                {{ __('Popular') }}
            </button>
        </div>
    </div>

    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'new'"
        x-transition:enter.duration.400ms>
        <meta itemprop="name" content="{{ __($title) . ' ' . __('New') }}" />
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.components.carousel', [
            'items' => $items[0],
            'blade' => "insight.{$model}.components.card",
            'endpoint' => route($route, array_merge($routeData, ['type' => $model, 'order' => 'new'])),
        ])
    </div>

    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
        x-transition:enter.duration.400ms>
        <meta itemprop="name" content="{{ __($title) . ' ' . __('Popular') }}" />
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.components.carousel', [
            'items' => $items[1],
            'blade' => "insight.{$model}.components.card",
            'endpoint' => route($route, array_merge($routeData, ['type' => $model, 'order' => 'popular'])),
        ])
    </div>
</section>
