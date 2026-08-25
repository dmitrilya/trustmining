<x-app-layout :title="'Калькулятор майнинга ' .
    ($rModel ? ($rVersion ? $selModel['n'] . ' ' . $selVersion['h'] . $selVersion['m'] : $selModel['n']) : 'онлайн') .
    ': доходность и окупаемость'" :description="($rModel
    ? ($rVersion
        ? 'Узнайте, сколько приносит ' . $selModel['n'] . ' ' . $selVersion['h'] . $selVersion['m'] . ' сегодня. '
        : 'Узнайте, сколько приносит ' . $selModel['n'] . ' сегодня. ')
    : '') . 'Рассчитайте доход, расход, прибыль и срок окупаемости асиков в онлайн калькуляторе доходности майнинга'"
    canonical="{{ $rModel && !$rVersion
        ? route('calculator.modelver', [
            'asicModel' => $selModel['s'],
            'asicVersion' => $selVersion['h'],
        ])
        : url()->current() }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Mining calculator') }} @if ($rModel)
                <span class="hidden xs:inline">{{ $selModel['n'] }}</span>
            @endif
        </h1>
    </x-slot>

    <div class="max-w-8xl mx-auto px-2 py-4 sm:p-4 lg:p-6">
        <div class="xl:flex items-start gap-4">
            <div class="flex-1 min-w-0 xl:max-w-[calc(100%-400px)]">
                <div itemscope itemtype="https://schema.org/ViewAction"
                    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 pt-3 sm:p-4">
                    @include('calculator.components.calculator')

                    @include('calculator.components.description')

                    <div class="mt-4 sm:mt-6 md:px-2 lg:px-4 md:pb-2 lg:pb-4">
                        @include('calculator.components.liked')
                    </div>
                </div>

                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                            {{ __('Best value offers') }} {{ $selModel['n'] }}
                        </h2>
                    </div>

                    <div>
                        <x-carousel.carousel :items="$ads" blade="ad.components.card" model="ad" :big="true" />
                    </div>
                </section>
            </div>

            <div x-data="{ isXL: window.matchMedia('(min-width: 1280px)').matches }" x-init="if (!isXL) {
                window.addEventListener('resize', () => {
                    if (window.matchMedia('(min-width: 1280px)').matches) {
                        isXL = true;
                        window.removeEventListener('resize', checkScreen);
                    }
                });
            }" class="hidden xl:flex flex-col gap-4 w-sm max-w-sm">
                <template x-if="isXL">
                    <div class="flex flex-col gap-4 w-full">
                        <div style="min-height: 435px"
                            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-3">
                            <script src="https://trustmining.ru/build/assets/difficulty-widjet.js" data-theme="dark" data-blocks="prediction,history"></script>
                        </div>

                        <x-ai-kodex targetWidth="1280" />

                        @include('layouts.components.solutions-blurb1')

                        @if ($article = App\Models\Insight\Content\Article::find(10000004))
                            @include('insight.article.components.card', [
                                'channel' => $article->channel->slug,
                                'article' => $article,
                            ])
                        @endif
                    </div>
                </template>
            </div>
        </div>

        @include('calculator.components.faq')
    </div>
</x-app-layout>
