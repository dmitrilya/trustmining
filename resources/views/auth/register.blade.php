<x-guest-layout :title="__('meta.auth.register.title')" :description="__('meta.auth.register.description')">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-inputs.input-label for="name" :value="__('Name') . ' ' . {{ __('or') }} . ' ' . __('Company name')" />
            <x-inputs.text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-inputs.input-error :messages="$errors->get('name')" />
        </div>

        <div class="mt-4">
            <x-inputs.input-label for="email" :value="__('Email')" />
            <x-inputs.text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-inputs.input-error :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-inputs.input-label for="password" :value="__('Password')" />

            <x-inputs.text-input id="password" type="password" name="password" required autocomplete="new-password" />

            <x-inputs.input-error :messages="$errors->get('password')" />
        </div>

        <div class="mt-4">
            <x-inputs.input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-inputs.text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-inputs.input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="mt-4">
            <p class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs">
                {{ __('By clicking the "Register" button, I accept the terms of') }} <a class="inline text-indigo-300 hover:text-indigo-600"
                    href="{{ route('document', ['path' => 'documents/agreement.pdf']) }}">{{ __('the User Agreement') }}</a>
                {{ __('and the terms of') }} <a class="inline text-indigo-300 hover:text-indigo-600"
                    href="{{ route('document', ['path' => 'documents/privacy.pdf']) }}">{{ __('the Privacy Policy') }}</a>.
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800"
                href="{{ route('login') }}">
                {{ __('Login') }}
            </a>

            <x-buttons.primary-button class="ml-4">
                {{ __('Register') }}
            </x-buttons.primary-button>
        </div>
    </form>

    @include('auth.socials')
</x-guest-layout>
