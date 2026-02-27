<x-app-layout :title="'Калькулятор майнинга: рассчитать доходность ' .
    ($rModel ? ($rVersion ? $selModel->name . ' ' . $selVersion->hashrate : $selModel->name) : 'ASIC')" :description="'Рассчитать доход, расход, прибыль и окупаемость асиков' .
    ($rModel ? ($rVersion ? ' ' . $selModel->name . ' ' . $selVersion->hashrate : ' ' . $selModel->name) : '') .
    ' в удобном калькуляторе доходности майнинга'"
    canonical="{{ $rModel && !$rVersion ? route('calculator.modelver', [
        'asicModel' => strtolower(str_replace(' ', '_', $selModel->name)),
        'asicVersion' => $selVersion->hashrate,
    ]) : null }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Mining calculator') }}
        </h1>
    </x-slot>

    <div class="max-w-8xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="grid xl:grid-cols-4 gap-4 sm:gap-6 items-start">
            @include('calculator.components.calculator')

            <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-1 gap-4">
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
    </div>
</x-app-layout>
