<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @auth
        <meta name="user-id" content="{{ \Auth::user()->id }}">
    @endauth

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased overflow-x-hidden">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" x-data="{ filter: false }">
        @include('layouts.navigation')

        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            {{ $slot }}

            <x-modal name="need-subscription">
                <div class="p-6">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('This feature is only available with a subscription') }}
                        </h2>

                        <button type="button"
                            class="ml-4 mt-1 flex h-6 w-6 items-center justify-center rounded-md bg-white text-gray-400"
                            @click="show = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    @include('tariff.components.subscription')
                </div>
            </x-modal>

            <x-modal name="tg-auth" :show="true">
                <div class="p-6">
                    <div class="flex justify-between mb-6">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Telegram authorization') }}
                        </h2>

                        <button type="button"
                            class="ml-4 mt-1 flex h-6 w-6 items-center justify-center rounded-md bg-white text-gray-400"
                            @click="show = false">
                            <span class="sr-only">Close menu</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('You need to authorize your telegram account, where notifications will be sent') }}
                    </p>

                    <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="trust_m_notifications_bot"
                        data-size="medium" data-radius="6" data-auth-url="https://trustmining.ru/tg/auth" data-request-access="write">
                    </script>
                </div>
            </x-modal>
        </main>
    </div>

    @if (request()->route()->action['as'] !== 'roadmap')
        @include('layouts.footer')
    @endif

    <div id="toasts" class="fixed bottom-5 right-5 w-full max-w-xs space-y-2"
        @error('forbidden')x-init="pushToastAlert('{{ $errors->first() }}', 'error')"@enderror
        @error('success')x-init="pushToastAlert('{{ $errors->first() }}', 'success')"@enderror></div>
</body>

</html>
