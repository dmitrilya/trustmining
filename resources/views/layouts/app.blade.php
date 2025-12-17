<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @if ($attributes->has('canonical'))
        <link rel="canonical" href="{{ $attributes->get('canonical') }}">
    @endif

    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $theme = $theme = request()->cookie('theme');
        $exceptAgents = ['bingbot', 'Googlebot', 'YandexBot', 'YandexMobileBot', 'GeedoShopProductFinder', 'SERankingBacklinksBot', 'Chrome-Lighthouse', 'PerplexityBot'];
        $agent = request()->header('User-Agent');
        $isBot = false;

        foreach ($exceptAgents as $exceptAgent) {
            if (str_contains($agent, $exceptAgent)) {
                $isBot = true;
                break;
            }
        }
    @endphp

    <meta name="color-scheme" content="light dark">

    @auth
        <meta name="user-id" content="{{ ($user = Auth::user())->id }}">
    @endauth

    <title>
        @if ($attributes->has('title'))
            {{ $attributes->get('title') }}@else{{ config('app.name') }}
        @endif
    </title>

    @if ($attributes->has('description'))
        <meta name="description" content="{{ $attributes->get('description') }}">
    @endif

    <!-- Yandex.Metrika counter -->
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
    <!-- /Yandex.Metrika counter -->

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
    <div class="min-h-screen bg-gray-100 dark:bg-zinc-950" x-data="{ filter: false }">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white dark:bg-zinc-900 shadow">
                <div class="max-w-7xl mx-auto p-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}

            <x-modal name="need-subscription">
                <div class="p-6">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-lg text-gray-950 dark:text-gray-50">
                            {{ __('This feature is only available with a subscription') }}
                        </h2>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 mt-1 flex h-6 w-6 items-center justify-center rounded-md bg-white text-gray-500"
                            @click="show = false">
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @include('tariff.components.subscription')
                </div>
            </x-modal>

            @auth
                @if ($user->tariff && $user->tg_id === null)
                    <x-modal name="tg-auth">
                        <div class="p-6">
                            <div class="flex justify-between mb-6">
                                <h2 class="text-lg text-gray-950 dark:text-gray-50">
                                    {{ __('Telegram authorization') }}
                                </h2>

                                <button type="button" aria-label="{{ __('Close') }}"
                                    class="ml-4 mt-1 flex h-6 w-6 items-center justify-center rounded-md bg-white text-gray-500"
                                    @click="show = false">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <p class="mt-1 text-sm text-gray-700 dark:text-gray-300 mb-5">
                                {{ __('You can log in using Telegram to receive notifications from our bot') }}
                            </p>

                            <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="trust_m_notifications_bot"
                                data-size="medium" data-radius="6" data-auth-url="https://trustmining.ru/tg/auth" data-request-access="write">
                            </script>

                            <div class="flex items-center justify-between mt-6">
                                <x-checkbox name="dont_ask" value="true" textClasses="text-gray-500 text-xxs py-3">
                                    {{ __("Don't ask again") }}
                                </x-checkbox>

                                <x-danger-button class="ml-3 text-xxs"
                                    @click="if($el.previousElementSibling.getElementsByTagName('input')[0].checked) {axios.patch('/tg/dont-ask');window.tgDontAsk = true}show = false">
                                    {{ __('Not interested') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </x-modal>
                @endif
            @endauth
        </main>
    </div>

    @if (request()->route()->action['as'] !== 'roadmap')
        @include('layouts.footer')
    @endif

    <div id="toasts" class="fixed bottom-5 right-5 w-full max-w-xs space-y-2"
        @error('forbidden')x-init="pushToastAlert('{{ $errors->first() }}', 'error')"@enderror
        @error('success')x-init="pushToastAlert('{{ $errors->first() }}', 'success')"@enderror>
    </div>
</body>

</html>
