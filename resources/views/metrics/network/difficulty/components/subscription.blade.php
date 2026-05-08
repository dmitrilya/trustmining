<x-modal name="difficulty-subscription" maxWidth="xs" rounded="rounded-xl">
    <div class="p-4 lg:p-6">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Network difficulty subscription') }} {{ $coin->abbreviation }}
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

        <form method="POST" action="{{ route('difficulty-subscribe', ['coin' => strtolower($coin->name)]) }}"
            @submit.prevent="axios.post($el.action).then(r => {
                if (!r.data.success) pushToastAlert(r.data.message, 'error');
                else pushToastAlert(r.data.message, 'success');
            })">
            @csrf

            <x-select name="type_id" :items="\App\Models\Metrics\DifficultySubscriptionType::all()
                ->map(
                    fn($type) => [
                        'key' => $type->id,
                        'value' => __($type->name),
                    ],
                )
                ->keyBy('key')" />

            <x-primary-button class="mt-4 block w-full">
                {{ __('Subscribe') }}
            </x-primary-button>
        </form>
    </div>
</x-modal>
