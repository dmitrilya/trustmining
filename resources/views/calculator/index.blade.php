<x-app-layout :title="'Калькулятор майнинга: рассчитать доходность ' .
    ($rModel ? ($rVersion ? $selModel->name . ' ' . $selVersion->hashrate : $selModel->name) : 'ASIC')" :description="'Рассчитать доход, расход, прибыль и окупаемость асиков' .
    ($rModel ? ($rVersion ? ' ' . $selModel->name . ' ' . $selVersion->hashrate : ' ' . $selModel->name) : '') .
    ' в удобном калькуляторе доходности майнинга'"
    canonical="{{ $rModel && !$rVersion
        ? route('calculator.modelver', [
            'asicModel' => $selModel->slug,
            'asicVersion' => $selVersion->hashrate,
        ])
        : null }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Mining calculator') }}
        </h1>
    </x-slot>

    <div class="max-w-8xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4 sm:gap-6 items-start">
            <div class="xl:col-span-3">
                <div itemscope itemtype="https://schema.org/ViewAction"
                    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-xl min-h-[616px] md:min-h-[460px] p-2 pt-3 sm:p-4">
                    @include('calculator.components.calculator')

                    @include('calculator.components.description')
                </div>

                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                            {{ __('Best value offers') }} {{ $selModel->name }}
                        </h2>
                    </div>

                    <div>
                        @include('home.components.carousel', [
                            'items' => $ads,
                            'blade' => 'ad.components.card',
                            'model' => 'ad',
                            'bigWrapper' => true,
                        ])
                    </div>
                </section>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-1 gap-4">
                @include('calculator.components.liked')
                @include('calculator.components.difficulty')

                <div class="hidden xl:block">
                    @include('layouts.components.solutions-blurb1')
                </div>

                @php
                    $article = App\Models\Insight\Content\Article::find(10000004);
                @endphp

                @if ($article)
                    @include('insight.article.components.card', [
                        'channel' => $article->channel->slug,
                        'article' => $article,
                    ])
                @endif
            </div>
        </div>

        @include('calculator.components.faq')
    </div>
</x-app-layout>
