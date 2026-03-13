<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    @vite(['resources/css/calculator.css', 'resources/js/calculator.js'])
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
        <div itemscope itemtype="https://schema.org/ViewAction" class="bg-slate-100 dark:bg-slate-950 p-2 pt-3 sm:p-4">
            <a href="{{ route('home') }}" target="_blank" class="flex mb-6 md:mb-4 md:px-6 lg:px-9 xl:px-12">
                <x-application-logo lang="en" />
                <h1 class="ml-1.5 text-base font-bold text-slate-900 dark:text-slate-100">
                    CALCULATOR
                </h1>
            </a>
            @include('calculator.components.calculator', ['widjet' => true])
        </div>
    </main>
</body>

</html>


{{-- http://localhost:8000/api/calculator-widjet?blocks=[]=additional-params&blocks[]=coins&blocks[]=characteristics&blocks[]=currency&theme=light --}}
