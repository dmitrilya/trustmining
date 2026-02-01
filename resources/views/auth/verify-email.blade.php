<x-guest-layout title="Подтверждение email - завершение регистрации в TrustMining" description="Подтвердите адрес электронной почты, чтобы завершить регистрацию в TrustMining и получить полный доступ к платформе для майнеров, продавцов, экспертов и сервисных компаний">
    <div class="mb-4 text-sm text-gray-700 dark:text-gray-300">
        {{ __("Before continuing, you'll need to confirm your email address by clicking the link we just sent you. If you haven't received the email, we'll be happy to send you another one.") }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form class="mt-3 sm:mt-4" method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="block ml-auto underline text-sm text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Logout') }}
            </button>
        </form>
    </div>
</x-guest-layout>
