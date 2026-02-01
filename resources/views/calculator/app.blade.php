<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $theme = $theme = request()->cookie('theme');
        $exceptAgents = ['bot', 'finder', 'Chrome-Lighthouse', 'googleother', 'crawler'];
        $agent = strtolower(request()->header('User-Agent'));
        $isBot = false;

        foreach ($exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) {
                $isBot = true;
                break;
            }
        }
    @endphp

    <title>Калькулятор доходности майнинга — расчет прибыли и окупаемости TrustMining</title>
    <meta name="description"
        content="Онлайн-калькулятор доходности оборудования TrustMining: узнайте ежедневную прибыль, сроки окупаемости и чистый доход с учетом затрат на электроэнергию и актуального курса">

    @if (!$isBot)
        <script type="text/javascript">
            (function(m, e, t, r, i, k, a) {
                m[i] = m[i] || function() {
                    (m[i].a = m[i].a || []).push(arguments)
                };
                m[i].l = 1 * new Date();
                for (var j = 0; j < document.scripts.length; j++) {
                    if (document.scripts[j].src === r) {
                        return;
                    }
                }
                k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode
                    .insertBefore(
                        k, a)
            })(window, document, 'script', 'https://mc.yandex.ru/metrika/tag.js?id=103577303', 'ym');

            ym(103577303, 'init', {
                ssr: true,
                webvisor: true,
                clickmap: true,
                ecommerce: "dataLayer",
                accurateTrackBounce: true,
                trackLinks: true
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/103577303" style="position:absolute; left:-9999px;"
                    alt="" />
            </div>
        </noscript>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased overflow-x-hidden {{ $theme ?? 'light' }}" x-data="{ theme: '{{ $theme ?? 'light' }}' }"
    @if (!$theme) x-init="if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.body.classList.add('dark');
                document.body.classList.remove('light');
                theme = 'dark';
            } else {
                document.body.classList.add('light');
                document.body.classList.remove('dark');
                theme = 'light';
            }" @endif>
    <div class="min-h-screen bg-gray-100 dark:bg-zinc-950">
        <nav class="bg-white dark:bg-zinc-900 border-b border-gray-100 dark:border-zinc-800">
            <div class="max-w-7xl mx-auto px-2 xs:px-4 sm:px-6 lg:px-8 py-1">
                <div class="flex justify-between h-10 lg:h-14">
                    <div class="w-full flex">
                        <div class="shrink-0 flex items-center">
                            <x-application-logo class="h-5" />
                            <h1 class="ml-2 text-[19px] text-gray-900 dark:text-gray-100 leading-tight">
                                CALCULATOR
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        @php
            $selModel = $models->first();
            $selVersion = $rVersion
                ? $selModel->asicVersions->where('hashrate', $rVersion)->first()
                : $selModel->asicVersions->first();
            if (!$selVersion) {
                $selVersion = $selModel->asicVersions->first();
            }
        @endphp

        <main>
            <div class="max-w-8xl mx-auto px-2 sm:px-6 lg:px-8 py-2">
                <div class="grid xl:grid-cols-4 gap-4 sm:gap-6 items-start">
                    <div itemscope itemtype="https://schema.org/ViewAction"
                        class="bg-white dark:bg-zinc-900 shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 xl:col-span-3 min-h-[616px] md:min-h-[460px]">
                        <meta itemprop="name"
                            content="{{ __('Income calculator') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }}" />
                        <meta itemprop="description"
                            content="{{ __('Calculate revenue, expenses, profit, and ROI for an ASIC miner') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }} {{ __('in a convenient mining calculator') }}" />

                        <div itemprop="object" itemscope itemtype="https://schema.org/Product"
                            class="md:grid grid-cols-5" x-data="{ currency: 'RUB', tariff: 5, version: {{ $selVersion }}, profitNumber: 0 }">
                            <div class="md:p-6 lg:p-9 xl:p-12 col-span-2">
                                <div class="mb-6">
                                    <x-input-label for="price" :value="__('Tariff')" />
                                    <x-text-input ::value="tariff" @input="tariff = $el.value" id="price"
                                        name="price" min="0" max="10" type="number" step="0.01" />
                                </div>

                                @include('calculator.components.schema')

                                @include('calculator.components.selectversion', [
                                    'selectedModel' => $selModel,
                                    'selectedVersion' => $selVersion,
                                ])

                                <template x-if="version !== null">
                                    <div class="mt-6 sm:mt-8 lg:mt-10">
                                        <div class="mt-4 sm:mt-6">
                                            <h3 class="sr-only">{{ __('Reviews') }}</h3>
                                            <div class="flex items-center" x-data="{ momentRating: version.reviews_avg }">
                                                <x-rating></x-rating>

                                                <a :href="'/database/' + version.brand_name + '/' + version.model_name +
                                                    '/reviews'"
                                                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                                    <span x-text="version.reviews_count"></span>
                                                    {{ __('reviews') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mt-3 sm:mt-4 space-y-1 sm:space-y-2">
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Algorithm') }}:
                                                <span class="text-gray-900 dark:text-gray-100 font-bold"
                                                    x-text="version.algorithm"></span>
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Power') }}:
                                                <span class="text-gray-900 dark:text-gray-100 font-bold"
                                                    x-text="version.efficiency * version.hashrate"></span> W
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Average price') }}: <span
                                                    class="text-gray-900 dark:text-gray-100 font-bold"
                                                    x-text="version.price ? version.price + ' USDT' : '{{ __('No data') }}'"></span>
                                            </div>
                                        </div>
                                        <template x-if="version.ads.length">
                                            <a class="pt-3 sm:pt-4 lg:pt-6"
                                                :href="'/ads/miners?model=' + version.model_name">
                                                <x-primary-button
                                                    class="text-xxs sm:text-xs">{{ __('Find ads') }}</x-primary-button>
                                            </a>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <div
                                class="mt-6 md:mt-0 md:p-6 lg:p-9 xl:p-12 md:border-l border-gray-300 dark:border-zinc-700 col-span-3">
                                <div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
                                    <h4 class="text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                                        {{ __('Calculation result') }}</h4>
                                    <div class="flex cursor-pointer mx-3">
                                        <button
                                            :class="{
                                                'bg-primary-gradient text-white': currency ==
                                                    'RUB',
                                                'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': currency ==
                                                    'USDT'
                                            }"
                                            class="p-1 rounded-l border border-r-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                                            @click="currency = 'RUB'">RUB</button>
                                        <button
                                            :class="{
                                                'bg-primary-gradient text-white': currency ==
                                                    'USDT',
                                                'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': currency ==
                                                    'RUB'
                                            }"
                                            class="p-1 rounded-r border border-l-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                                            @click="currency = 'USDT'">USDT</button>
                                    </div>
                                </div>

                                <template x-if="version !== null">
                                    <div>
                                        <div class="grid grid-cols-4 gap-2 sm:gap-4">
                                            <div></div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Income') }}
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Expense') }}
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Profit') }}
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Day') }}
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 10000) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 24 * 10) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 24 / 1000) * 10000) / 10000">
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Month') }}
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 30 * 10000) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 720 * 10) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 30 - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 720 / 1000) * 10000) / 10000">
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                                                {{ __('Year') }}
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 365 * 10000) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 8760 * 10) / 10000">
                                            </div>
                                            <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 365 - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 8760 / 1000) * 10000) / 10000">
                                            </div>
                                        </div>

                                        <div
                                            class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300 mt-6 sm:mt-7 lg:mt-8">
                                            {{ __('Payback') }}:
                                            <span class="text-gray-900 dark:text-gray-100 font-bold"
                                                x-text="version.price ? 
                                        version.profits[profitNumber].profit - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 / 1000 > 0 ?
                                        Math.round(version.price / (version.profits[profitNumber].profit - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 / 1000)) + ' {{ __('Days') }}' :
                                        '∞' : '{{ __('No data') }}'"></span>
                                        </div>

                                        <h4
                                            class="text-xs sm:text-sm text-gray-700 dark:text-gray-200 mt-6 sm:mt-7 lg:mt-8">
                                            {{ __('Coins per day') }}</h4>

                                        <template x-for="(profit, i) in version.profits" :key="'profit_' + i">
                                            <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer"
                                                @click="profitNumber = i">
                                                <div>
                                                    <label class="flex items-center">
                                                        <input type="radio" name="profitNumber"
                                                            :value="i"
                                                            :aria-label="'{{ __('Change calculation to') }}' + ' ' + profit.coins[0]
                                                                .name"
                                                            :checked="profitNumber == i"
                                                            class="mr-2 w-3 h-3 sm:w-4 sm:h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-zinc-800 dark:border-zinc-700 cursor-pointer">
                                                    </label>
                                                </div>
                                                <template x-for="coin in profit.coins" :key="coin.abbreviation">
                                                    <div>
                                                        <div class="flex items-center">
                                                            <img :src="'/storage/coins/' + coin.abbreviation + '.webp'"
                                                                :alt="coin.name"
                                                                class="w-3 xs:w-4 sm:w-5 mr-1 xs:mr-2">
                                                            <div>
                                                                <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300"
                                                                    x-text="coin.abbreviation">
                                                                </div>
                                                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400"
                                                                    x-text="coin.name">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-xxs xs:text-xs text-gray-700 dark:text-gray-200 font-bold mt-1"
                                                            x-text="Math.round(version.hashrate * coin.profit * version.coef * 100000000) / 100000000">
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        <a class="block mt-6 xl:mt-8"
                                            x-bind:href="'/database/' + version.brand_name + '/' + version.model_name">
                                            <x-secondary-button>{{ __('Model details about miner') }}</x-secondary-button>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
