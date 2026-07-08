<x-profile.section h="Update Password" p="Ensure your account is using a long, random password to stay secure">
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-inputs.input-label for="current_password" :value="__('Current Password')" />
            <x-inputs.text-input id="current_password" name="current_password" type="password"
                autocomplete="current-password" />
            <x-inputs.input-error :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-inputs.input-label for="password" :value="__('New Password')" />
            <x-inputs.text-input id="password" name="password" type="password" autocomplete="new-password" />
            <x-inputs.input-error :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-inputs.input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-inputs.text-input id="password_confirmation" name="password_confirmation" type="password"
                autocomplete="new-password" />
            <x-inputs.input-error :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <x-buttons.primary-button>{{ __('Save') }}</x-buttons.primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600 dark:text-slate-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</x-profile.section>
