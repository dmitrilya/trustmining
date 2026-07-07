<section class="mt-4 sm:mt-6 lg:mt-8" x-data="{ tab: 'simmilar' }">
    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
        <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
            {{ __('Compare with') }}
        </h2>

        <div class="flex text-xs s m:text-sm">
            <button @click="tab = 'simmilar'"
                :class="tab === 'simmilar' ?
                    'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-600 dark:text-slate-400' :
                    'text-slate-500'"
                class="px-3 py-1 rounded-full transition-all">
                {{ __('Similar') }}
            </button>
            <button @click="tab = 'popular'"
                :class="tab === 'popular' ?
                    'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-600 dark:text-slate-400' :
                    'text-slate-500'"
                class="px-3 py-1 rounded-full transition-all">
                {{ __('Popular') }}
            </button>
        </div>
    </div>

    <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'simmilar'" x-transition:enter.duration.400ms>
        <meta itemprop="name" content="{{ __('Comparing with') . ' ' . __('Similar') }}" />
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('database.asic-miners.compare-carousel', [
            'asicModels' => $comparing['same_algo'],
            'characteristics' => [
                [
                    'name' => __('Speed'),
                    'value' => fn($model) => $model->maxRate . ' ' . $model->algorithm->measurement . '/s',
                ],
            ],
        ])
    </div>

    <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
        x-transition:enter.duration.400ms>
        <meta itemprop="name" content="{{ __('Comparing with') . ' ' . __('Popular') }}" />
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('database.asic-miners.compare-carousel', [
            'asicModels' => $comparing['diff_algo'],
            'characteristics' => [
                [
                    'name' => __('Release'),
                    'value' => fn($model) => $model->release->locale(app()->getLocale())->translatedFormat('F Y'),
                ],
            ],
        ])
    </div>
</section>
