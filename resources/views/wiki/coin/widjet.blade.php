<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">

    <meta name="robots" content="noindex, nofollow">

    @if (!is_bot_request())
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
                trackLinks: true,
                params: {
                    widget_host: "{{ $parentUrl }}"
                }
            });
        </script>
        <noscript>
            <div><img src="https://mc.yandex.ru/watch/103577303" style="position:absolute; left:-9999px;" alt="" />
            </div>
        </noscript>
    @endif

    @vite(['resources/css/widjets/coin-info.css', 'resources/js/widjets/coin-info.js'])
</head>

<body class="font-sans antialiased overflow-hidden {{ $theme ?? 'light' }}" x-data="{ currentTheme: '{{ $theme ?? 'light' }}' }" x-init="@if (!$theme) if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        currentTheme = 'dark';
    } @endif

$watch('currentTheme', value => {
    if (value === 'dark') {
        $el.classList.add('dark');
        $el.classList.remove('light');
    } else {
        $el.classList.add('light');
        $el.classList.remove('dark');
    }
});"
    x-on:message.window="if ($event.data && $event.data.type === 'THEME_CHANGE') {
            currentTheme = $event.data.theme;
        }">
    <main>
        <div itemscope itemtype="https://schema.org/ViewAction">
            <a target="_blank" class="flex items-center mb-4 md:px-6 lg:px-9 xl:px-12" href="{{ route('home') }}">
                <x-application-logo lang="en" />
                <h1 class="ml-1.5 text-[0.9rem] font-bold text-slate-800 dark:text-slate-200">
                    COIN STAT
                </h1>
            </a>

            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 sm:p-5 shadow-lg">
                <!-- Шапка: Логотип, Курс, Изменение и Хэшрейт -->
                <div
                    class="flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">

                    <!-- Левая часть: Монета и Курс -->
                    <div class="flex items-center gap-3">
                        <!-- Замените src на ваш путь к иконке -->
                        <img src="/path-to-coin-icon.svg" alt="Coin" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover shadow-sm" />
                        <div>
                            <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-0.5">
                                {{ __('Current rate') }}
                            </h3>
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg sm:text-xl lg:text-2xl font-black text-slate-800 dark:text-slate-200">
                                    {{ number_format($rate, 8, '.', '') }} <span class="text-xs sm:text-sm font-bold text-slate-500">USDT</span>
                                </span>
                                <!-- Изменение курса за 24ч (пример вывода, подставьте вашу переменную) -->
                                @if (isset($rate_change_24h))
                                    <span class="text-xs font-bold {{ $rate_change_24h >= 0 ? 'text-green-500' : 'text-red-500' }}">
                                        {{ $rate_change_24h >= 0 ? '+' : '' }}{{ $rate_change_24h }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Правая часть: Хэшрейт сети -->
                    <div class="sm:text-right w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-slate-100 dark:border-slate-800/50">
                        <h3 class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-0.5">
                            {{ __('Current hashrate') }}
                        </h3>
                        <div class="text-base sm:text-lg lg:text-xl font-extrabold text-slate-800 dark:text-slate-200">
                            {{ number_format($hashrate) }} <span class="text-xs font-medium text-slate-500">H/s</span>
                        </div>
                    </div>
                </div>

                <!-- Сетка Сложности Сети -->
                <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-stretch">

                    <!-- Блок: Текущая сложность -->
                    <div
                        class="md:col-span-2 bg-slate-50 dark:bg-slate-800/40 p-3 rounded-xl border border-slate-200 dark:border-slate-800/80 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 dark:text-slate-400 uppercase block mb-1">
                                {{ __('Current difficulty') }}
                            </h2>
                            <span class="text-lg sm:text-xl lg:text-2xl font-black text-slate-800 dark:text-slate-200 break-all leading-tight">
                                {{ number_format($difficulty->difficulty) }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center text-xxs text-slate-400 dark:text-slate-500">
                            <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>
                            {{ __('Current value for today') }}
                        </div>
                    </div>

                    <!-- Блок: Прогноз сложности и Прогресс -->
                    @if ($prediction !== null && in_array('prediction', $blocks))
                        <div
                            class="md:col-span-3 bg-slate-50 dark:bg-slate-800/40 p-3 rounded-xl border border-slate-200 dark:border-slate-800/80 flex flex-col justify-between gap-3">

                            <div class="flex justify-between gap-3 border-b border-slate-200 dark:border-slate-800/60 pb-2">
                                <div style="max-width: 50%">
                                    <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 dark:text-slate-400 uppercase block mb-1">
                                        {{ __('Difficulty prediction') }}
                                    </h2>
                                    <span
                                        class="text-xl sm:text-2xl lg:text-3xl font-black {{ $prediction > 0 ? 'text-green-500' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $prediction > 0 ? '+' : '' }}{{ $prediction }}%
                                    </span>
                                </div>

                                <div class="text-right flex-1 flex flex-col justify-between items-end">
                                    <div>
                                        <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 dark:text-slate-400 uppercase block mb-1">
                                            {{ __('Blocks before recalculation') }}
                                        </h2>
                                        <div class="flex items-baseline justify-end gap-0.5">
                                            <span class="text-sm sm:text-base font-bold text-slate-800 dark:text-slate-200">
                                                {{ $difficulty->need_blocks }}
                                            </span>
                                            <span class="text-xxs text-slate-400">/ 2016</span>
                                        </div>
                                    </div>
                                    <div class="mt-1">
                                        <h3 class="sr-only">{{ __('Time left until the calculation') }}</h3>
                                        <span class="text-xxs text-amber-600 dark:text-amber-400 font-medium block leading-tight">
                                            {{ $needBlocksTime }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            @php
                                $blocksPassed = max(0, 2016 - $difficulty->need_blocks);
                                $progressPercent = ($blocksPassed / 2016) * 100;
                            @endphp
                            <div class="w-full">
                                <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                    <!-- Заменен класс bg-linear-to-r на универсальный bg-gradient-to-r для обратной совместимости -->
                                    <div class="bg-linear-to-r from-indigo-500 to-indigo-700 h-1.5 rounded-full transition duration-500"
                                        style="width: {{ $progressPercent }}%">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center mt-1 text-xxs text-slate-400 dark:text-slate-500">
                                    <span>{{ __('Progress of the era') }}</span>
                                    <span class="font-medium text-slate-600 dark:text-slate-400">{{ round($progressPercent) }}%</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>

</html>
