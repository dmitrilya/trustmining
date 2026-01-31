<x-guest-layout title="TrustMining Авторизация" description="Авторизация на сайте TrustMining" description="Авторизация на TrustMining — вход для майнеров и клиентов инфраструктурных компаний. Получите доступ к проверенным предложениям, экспертному сообществу, обзорам оборудования и профессиональной экосистеме майнинга">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-zinc-950 border-gray-300 dark:border-zinc-800 text-indigo-600 shadow-sm dark:shadow-zinc-800 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-zinc-900"
                    name="remember">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-zinc-900"
                    href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Login') }}
            </x-primary-button>
        </div>

        <a class="mt-3 underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-zinc-900"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    </form>
</x-guest-layout>
