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

    @vite(['resources/css/widjets/coin-stat.css', 'resources/js/widjets/coin-stat.js'])
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
            <a target="_blank" class="flex items-center mb-4 px-2 lg:px-4" href="{{ route('home') }}">
                <x-application-logo lang="en" />
                <h1 class="ml-1.5 text-[0.9rem] font-bold text-slate-800 dark:text-slate-200">
                    {{ $coin->abbreviation }} STAT
                </h1>
            </a>

            <div>
                <div class="border border-slate-300 dark:border-slate-700 rounded-xl shadow shadow-logo-color p-2 sm:p-4 mb-2">
                    <div class="flex justify-between mb-2">
                        <div class="flex items-center">
                            <img src="{{ Storage::url('coins/64/' . $coin->abbreviation . '.webp') }}" alt="{{ $coin->name }} icon"
                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover shadow-sm mr-2 xs:mr-3" />
                            <div>
                                <h2 class="xs:text-base sm:text-lg font-bold text-slate-800 dark:text-slate-200">
                                    {{ $coin->name }}
                                </h2>
                                <div class="text-xs sm:text-sm text-slate-500">{{ $algorithm }}</div>
                            </div>
                        </div>

                        @if ($hashrate)
                            <div class="text-right">
                                <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1">
                                    {{ __('Current hashrate') }}
                                </h2>
                                <div class="text-base xs:text-lg sm:text-xl font-black text-slate-800 dark:text-slate-200">
                                    {{ number_format($hashrate) }} <span class="text-xs font-medium text-slate-500">{{ $measurement }}/s</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-lg sm:text-xl lg:text-2xl text-slate-800 dark:text-slate-200">
                            <span class="font-black">{{ adjust_rate($rate) }}</span> <span class="text-xs sm:text-sm text-slate-500">USDT</span>
                        </span>
                        @if (isset($rate_change))
                            <span class="text-xs font-bold {{ $rate_change >= 0 ? 'text-green-500' : 'text-red-600 dark:text-red-400' }}">
                                {{ $rate_change >= 0 ? '+' : '' }}{{ $rate_change }}%
                            </span>
                        @endif
                    </div>
                </div>

                @if ($difficultyData)
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 items-stretch">
                        <div
                            class="md:col-span-2 flex flex-col justify-between border border-slate-300 dark:border-slate-700 rounded-xl shadow shadow-logo-color p-2 sm:p-4">
                            <div>
                                <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1">
                                    {{ __('Current difficulty') }}
                                </h2>
                                <span class="text-xl xs:text-2xl lg:text-3xl font-black text-slate-800 dark:text-slate-200 break-all">
                                    {{ number_format($difficultyData['lastDifficulty']->difficulty) }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center text-xxs lg:text-xs text-slate-500">
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>
                                {{ __('Current value for today') }}
                            </div>
                        </div>

                        @if ($difficultyData['prediction'] !== null)
                            <div
                                class="md:col-span-3 flex flex-col justify-between gap-2 sm:gap-4 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl p-2 sm:p-4">
                                <div class="flex justify-between gap-2 pb-2">
                                    <div style="max-width: 60%">
                                        <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1">
                                            {{ __('Difficulty prediction') }}
                                        </h2>
                                        <span
                                            class="text-2xl xs:text-4xl lg:text-5xl font-black {{ $difficultyData['prediction'] > 0 ? 'text-green-500' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $difficultyData['prediction'] > 0 ? '+' : '' }}{{ $difficultyData['prediction'] }}%
                                        </span>
                                    </div>

                                    <div class="text-right flex-1 flex flex-col justify-between">
                                        <div>
                                            <h2
                                                class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1">
                                                {{ __('Blocks before recalculation') }}
                                            </h2>
                                            <div class="flex items-baseline justify-end gap-1">
                                                <span class="xs:text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-200">
                                                    {{ $difficultyData['lastDifficulty']->need_blocks }}
                                                </span>
                                                <span class="text-xs text-slate-500">/ 2016</span>
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="sr-only">{{ __('Time left until the calculation') }}</h3>
                                            <span
                                                class="text-xxs xxs:text-sm text-amber-600 dark:text-amber-400 font-medium block leading-tight">{{ $difficultyData['needBlocksTime'] }}</span>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $blocksPassed = max(0, 2016 - $difficultyData['lastDifficulty']->need_blocks);
                                    $progressPercent = ($blocksPassed / 2016) * 100;
                                @endphp
                                <div class="w-full">
                                    <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-linear-to-r from-indigo-500 to-indigo-700 h-1.5 rounded-full transition duration-500"
                                            style="width: {{ $progressPercent }}%">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center mt-1.5 text-xxs lg:text-xs text-slate-500">
                                        <span>{{ __('Progress of the era') }}</span>
                                        <span>{{ round($progressPercent) }}%</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>

</html>
