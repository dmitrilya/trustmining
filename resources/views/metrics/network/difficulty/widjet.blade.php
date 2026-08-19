<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">

    <meta name="robots" content="noindex, nofollow">

    <title>Сложность сети {{ $coin->name }}({{ $coin->abbreviation }}) сегодня: прогноз, онлайн график</title>
    <meta name="description"
        content="Актуальная сложность сети {{ $coin->name }}, онлайн-график, история изменений и прогноз следующего пересчёта. Данные обновляются в реальном времени">

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

    @vite(['resources/css/difficulty.css', 'resources/js/difficulty.js'])

    @if (in_array('graph', $blocks))
        @vite(['resources/js/graph.js'])
    @endif
</head>

<body class="font-sans antialiased overflow-hidden {{ $theme ?? 'light' }}"
    @if (!$theme) x-init="if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.body.classList.add('dark');
        document.body.classList.remove('light');
    } else {
        document.body.classList.add('light');
        document.body.classList.remove('dark');
    }" @endif>
    <main>
        <div x-data="{ period: '1y', items: [] }" x-init="fetch('{{ route('metrics.network.get_difficulty', ['coin' => strtolower($coin->name)]) }}')
            .then(r => r.json())
            .then(data => {
                @if(in_array('graph', $blocks))
                window.buildGraph(data.difficulties, period, 'graph', 'value');
                @endif
                difficulties = data.difficulties.reverse().slice(0, 76);
                items = difficulties.slice(0, 75).filter((difficulty, i) => difficulty.value != difficulties[i + 1].value);
            })">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center mb-4 md:px-6 lg:px-9 xl:px-12">
                <x-application-logo lang="en" />
                <h1 class="ml-1.5 text-[0.9rem] font-bold text-slate-800 dark:text-slate-200">
                    DIFFICULTY
                </h1>
            </a>
            @include('metrics.network.difficulty.components.difficulty', ['widjet' => true])

            @if (in_array('history', $blocks))
                <div x-data="{ show: false }" class="w-full">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-b border-indigo-600">
                                <th class="py-1.5 md:py-4 pr-4 text-left font-bold text-xs sm:text-sm text-slate-500">
                                    {{ __('Date') }}
                                </th>
                                <th class="py-1.5 md:py-4 pr-4 text-left font-bold text-xs sm:text-sm text-slate-500">
                                    {{ __('Network difficulty') }}
                                </th>
                                <th class="py-1.5 md:py-4 font-bold text-xs sm:text-sm text-right text-slate-500">
                                    {{ __('Change') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                            <template x-for="(item, i) in items.slice(0, items.length - 1)" :key="item.date">
                                <tr x-show="i < 5 || show" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

                                    <td class="py-1.5 lg:py-2 pr-4 text-xxs xxs:text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200 whitespace-nowrap"
                                        x-text="new Date(item.date).toLocaleString(window.locale, {
                                            year: 'numeric',
                                            month: 'short',
                                            day: 'numeric',
                                        })">
                                    </td>

                                    <td class="py-1.5 lg:py-2 pr-4 text-xxs xxs:text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200"
                                        x-text="item.value">
                                    </td>

                                    <td class="py-1.5 lg:py-2 text-xxs xxs:text-xs xs:text-sm sm:text-base text-right whitespace-nowrap"
                                        :class="{
                                            'text-green-500': item.value > items[i + 1]?.value,
                                            'text-red-500': item.value < items[i + 1]?.value,
                                            'text-slate-800 dark:text-slate-200': item.value == items[i + 1]?.value
                                        }"
                                        x-text="items[i + 1] ? (item.value > items[i + 1].value ? '+' + Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%' : Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%') : '—'">
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    <template x-if="items.length > 5">
                        <button @click="show = !show"
                            class="mt-3 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600 transition-colors duration-300">
                            <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
                        </button>
                    </template>
                </div>
            @endif
        </div>
    </main>
</body>

</html>

{{-- 
<script 
    src="https://trustmining.ru/build/assets/calculator-widjet.js" 
    data-theme="dark" 
    data-blocks="additional-params,coins,currency,characteristics">
</script>
                            
http://localhost:8000/api/calculator-widjet?blocks=[]=additional-params&blocks[]=coins&blocks[]=characteristics&blocks[]=currency&theme=light --}}
