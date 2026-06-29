<x-guest-layout title="Авторизация на TrustMining — вход для продавцов, покупателей и экспертов"
    description="Авторизация на TrustMining — вход для майнеров и клиентов инфраструктурных компаний. Получите доступ к проверенным предложениям, экспертному сообществу, обзорам оборудования и профессиональной экосистеме майнинга">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <x-checkbox class="block mt-4" textClasses="text-slate-600 dark:text-slate-400" name="remember"
            value="with_vat">
            {{ __('Remember me') }}
        </x-checkbox>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-slate-800 dark:text-slate-200 hover:text-slate-900 dark:hover:text-slate-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
                    href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        <a class="mt-3 underline text-sm text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    </form>

    <div class="relative flex py-5 items-center">
        <div class="flex-grow border-t border-slate-300 dark:border-slate-700"></div>
        <span class="flex-shrink mx-4 text-slate-500 text-xs uppercase tracking-wider">{{ __('or') }}</span>
        <div class="flex-grow border-t border-slate-300 dark:border-slate-700"></div>
    </div>

    <a href="https://oauth.yandex.ru/authorize?response_type=code&client_id={{ config('services.yandex_auth.id') }}">
        <x-secondary-button class="w-full">
            <div class="rounded-full overflow-hidden mr-3 sm:mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 44 44"
                    fill="none">
                    <rect width="44" height="44" fill="#FC3F1D" />
                    <path
                        d="M24.7407 33.9778H29.0889V9.04443H22.7592C16.3929 9.04443 13.0538 12.303 13.0538 17.1176C13.0538 21.2731 15.2187 23.6163 19.0532 26.1609L21.3832 27.6987L18.3927 25.1907L12.4667 33.9778H17.1818L23.5115 24.5317L21.3098 23.0671C18.6496 21.2731 17.3469 19.8818 17.3469 16.8613C17.3469 14.2068 19.2183 12.4128 22.7776 12.4128H24.7223V33.9778H24.7407Z"
                        fill="white" />
                </svg>
            </div>

            {{ __('Login via Yandex ID') }}
        </x-secondary-button>
    </a>
</x-guest-layout>
