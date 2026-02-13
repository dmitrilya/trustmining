<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $theme = request()->cookie('app_theme');
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
        <nav class="bg-white/60 dark:bg-zinc-900/60 border-b border-gray-100 dark:border-zinc-800">
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
            <div class="max-w-8xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
                <div class="grid xl:grid-cols-4 gap-4 sm:gap-6 items-start">
                    @include('calculator.components.calculator')
                </div>
            </div>
        </main>
    </div>
</body>

</html>
