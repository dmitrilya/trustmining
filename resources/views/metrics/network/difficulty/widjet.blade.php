<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">

    @php
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

    <title>Сложность сети {{ $coin->name }} | TRUSTMINING</title>
    <meta name="description"
        content="История изменений, текущий показатель и прогноз следующей сложности криптосети {{ $coin->name }} ({{ $coin->abbreviation }})">

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
        <div class="bg-slate-100 dark:bg-slate-950 p-2 sm:p-4" x-data="{ period: '1y', items: [] }" x-init="fetch('{{ route('metrics.network.get_difficulty', ['coin' => strtolower($coin->name)]) }}')
            .then(r => r.json())
            .then(data => {
                @if (in_array('graph', $blocks)) window.buildGraph(data.difficulties, period, 'graph', 'value'); @endif
                difficulties = data.difficulties.reverse().slice(0, 61);
                items = difficulties.slice(0, 60).filter((difficulty, i) => difficulty.value != difficulties[i + 1].value);
            })">
            <a href="{{ route('home') }}" target="_blank" class="flex mb-6 md:mb-4 md:px-6 lg:px-9 xl:px-12">
                <x-application-logo lang="en" />
                <h1 class="ml-1.5 text-[0.9rem] font-bold text-slate-900 dark:text-slate-100">
                    DIFFICULTY
                </h1>
            </a>
            @include('metrics.network.difficulty.components.difficulty', ['widjet' => true])

            <div class="grid grid-cols-6 gap-1 sm:gap-3 mb-2 sm:mb-3">
                <div class="col-span-2 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Date') }}</div>
                <div class="col-span-3 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Network difficulty') }}</div>
                <div class="col-span-1 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Change') }}</div>
            </div>
            <template x-for="(item, i) in items.slice(0, items.length - 1)" key="item.date">
                <div class="grid grid-cols-6 gap-1 sm:gap-3 mb-1 sm:mb-2">
                    <div class="col-span-2 text-xxs xs:text-xs sm:text-base lg:text-lg text-slate-800 dark:text-slate-200"
                        x-text="new Date(item.date).toLocaleString(window.locale, {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                        })">
                    </div>
                    <div class="col-span-3 text-xxs xs:text-xs sm:text-base lg:text-lg text-slate-800 dark:text-slate-200"
                        x-text="item.value"></div>
                    <div class="col-span-1 text-xxs xs:text-xs sm:text-base lg:text-lg"
                        :class="{
                            'text-green-500': item.value > items[i + 1].value,
                            'text-red-500': item.value < items[i +
                                1].value,
                            'text-slate-700 dark:text-slate-200': item.value == items[i + 1].value
                        }"
                        x-text="item.value > items[i + 1].value ? '+' + Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%' : Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%'">
                    </div>
                </div>
            </template>
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
