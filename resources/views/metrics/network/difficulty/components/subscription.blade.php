<x-modal name="difficulty-subscription" maxWidth="sm" rounded="rounded-xl">
    <div class="p-6 lg:p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Network difficulty subscription') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="trust_m_notifications_bot"
            data-size="medium" data-radius="6" data-auth-url="https://trustmining.ru/tg/auth" data-request-access="write">
        </script>

        <form method="POST" action="{{ route('difficulty-subscribe') }}">
            @csrf

            <x-select name="type_id" :key="$coin->id" :items="\App\Models\Metrics\DifficultySubscriptionType::all()
                ->map(
                    fn($type) => [
                        'key' => $type->id,
                        'value' => $type->name,
                    ],
                )
                ->keyBy('key')" />

            <div class="flex items-center justify-end mt-4">
                <button type="button" @click="show = false; $dispatch('open-modal', 'register');"
                    class="text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900">
                    {{ __('Register') }}
                </button>

                <x-primary-button class="ml-3">
                    {{ __('Login') }}
                </x-primary-button>
            </div>

            <a class="mt-3 text-sm text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900"
                href="{{ route('password.request') }}" target="_blank">
                {{ __('Forgot your password?') }}
            </a>
        </form>
    </div>
</x-modal>
