<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    @if ($attributes->has('header'))
        <x-slot name="header">
            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ $attributes->get('header') }}
            </h1>
        </x-slot>
    @endif

    <div class="max-w-10xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="lg:grid grid-cols-12 gap-4 items-start relative" x-data="{ isXL: window.matchMedia('(min-width: 1024px)').matches }" x-init="if (!isXL) window.initLazyComponent($data, '1024px')">
            <div class="hidden lg:flex flex-col lg:col-span-3 xl:col-span-2 gap-4">
                {{-- @include('home.components.categories') --}}
                <x-widjets.voting :category="\App\Enums\VotingCategory::best_hosting" type="widjet" />
                @include('insight.components.popular-article')
                <div class="p-2 sm:p-3 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
                    <script src="https://trustmining.ru/build/assets/coin-stat-widjet.js" data-coin="litecoin" data-theme="dark"
                        data-blocks="difficulty-prediction,difficulty,hashrate"></script>
                </div>
                @include('home.components.top-channels')
            </div>

            <div class="lg:col-span-6 xl:col-span-7">
                {{ $slot }}
            </div>

            <template x-if="isXL">
                <div class="hidden lg:flex flex-col lg:col-span-3 gap-4">
                    @include('home.components.asic-models')

                    @if ($btc = App\Models\Database\Coin::where('abbreviation', 'btc')->first())
                        <x-widjets.voting :category="\App\Enums\VotingCategory::coin_rate_prediction" :candidate="$btc" type="widjet" />
                    @endif

                    <x-ai-kodex targetWidth="1024" />
                    @include('home.components.asic-brands')
                    @include('home.components.last-forum-questions')

                    @if (isset($sidebar))
                        {{ $sidebar }}
                    @endif
                </div>
            </template>
        </div>
    </div>
</x-app-layout>
