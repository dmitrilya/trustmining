<x-guest-layout title="TrustMining Сбросить пароль" description="Сбросить пароль на сайте TrustMining" noindex="true">
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-inputs.input-label for="email" :value="__('Email')" />
            <x-inputs.text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                autocomplete="username" />
            <x-inputs.input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-inputs.input-label for="password" :value="__('Password')" />
            <x-inputs.text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-inputs.input-error :messages="$errors->get('password')" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-inputs.input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-inputs.text-input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" />

            <x-inputs.input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-buttons.primary-button>
                {{ __('Reset Password') }}
            </x-buttons.primary-button>
        </div>
    </form>
</x-guest-layout>
