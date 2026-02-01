<x-guest-layout title="Регистрация аккаунта — доступ к платформе TrustMining" description="Создайте аккаунт на TrustMining и получите доступ к каталогу майнингового оборудования, сервисных компаний, экспертов и возможностям взаимодействия внутри криптоэкосистемы">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name') . ' или ' . __('Company name')" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mt-4">
            <p class="text-gray-700 dark:text-gray-300 text-xxs sm:text-xs">
                {{ __('By clicking the "Register" button, I accept the terms of') }} <a class="inline text-indigo-300 hover:text-indigo-500" href="{{ route('document', ['path' => 'documents/agreement.pdf']) }}">{{ __('the User Agreement') }}</a> {{ __('and the terms of') }} <a class="inline text-indigo-300 hover:text-indigo-500" href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('the Privacy Policy') }}</a>.
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}">
                {{ __('Login') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
