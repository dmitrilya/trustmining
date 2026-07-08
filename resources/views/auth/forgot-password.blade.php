<x-guest-layout title="Восстановление пароля"
    description="Восстановите пароль к аккаунту TrustMining и снова получите доступ к объявлениям компаний, оборудованию для майнинга и экспертному сообществу платформы"
    noindex="true">
    <div class="mb-4 text-sm text-slate-600 dark:text-slate-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-inputs.input-label for="email" :value="__('Email')" />
            <x-inputs.text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
            <x-inputs.input-error :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-buttons.primary-button>
                {{ __('Email Password Reset Link') }}
            </x-buttons.primary-button>
        </div>
    </form>
</x-guest-layout>
