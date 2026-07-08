<x-guest-layout title="Авторизация на TrustMining — вход для продавцов, покупателей и экспертов"
    description="Авторизация на TrustMining — вход для майнеров и клиентов инфраструктурных компаний. Получите доступ к проверенным предложениям, экспертному сообществу, обзорам оборудования и профессиональной экосистеме майнинга">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-inputs.input-label for="email" :value="__('Email')" />
            <x-inputs.text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username" />
            <x-inputs.input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-inputs.input-label for="password" :value="__('Password')" />
            <x-inputs.text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-inputs.input-error :messages="$errors->get('password')" />
        </div>

        <x-inputs.checkbox class="block mt-4" textClasses="text-slate-600 dark:text-slate-400" name="remember"
            value="with_vat">
            {{ __('Remember me') }}
        </x-inputs.checkbox>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('register'))
                <a class="underline text-sm text-slate-800 dark:text-slate-200 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
                    href="{{ route('register') }}">
                    {{ __('Register') }}
                </a>
            @endif

            <x-buttons.primary-button class="ml-3">
                {{ __('Login') }}
            </x-buttons.primary-button>
        </div>

        <a class="mt-3 underline text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
        </a>
    </form>

    @include('auth.socials')
</x-guest-layout>
