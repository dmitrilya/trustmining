<x-profile.section h="Balance and tariff plan"
    p="You can top up your balance with any amount, but to activate the tariff, the amount must exceed your monthly expenses. If your balance is not enough for daily debits, the tariff will be reset to Base">
    <x-slot name="i">
        <a class="block hover:underline text-xs sm:text-sm text-indigo-500 hover:text-indigo-600"
            href="{{ route('tariffs') }}">{{ __('Tariffs') }} ➚</a>
    </x-slot>

    <x-characteristics.characteristics>
        <x-characteristics.characteristic name="Active tariff" :value="$user->tariff ? $user->tariff->name : 'Base'" />
    </x-characteristics.characteristics>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-slate-800 dark:text-slate-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M12 14a3 3 0 0 1 3-3h4a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-4a3 3 0 0 1-3-3Zm3-1a1 1 0 1 0 0 2h4v-2h-4Z"
                    clip-rule="evenodd" />
                <path fill-rule="evenodd"
                    d="M12.293 3.293a1 1 0 0 1 1.414 0L16.414 6h-2.828l-1.293-1.293a1 1 0 0 1 0-1.414ZM12.414 6 9.707 3.293a1 1 0 0 0-1.414 0L5.586 6h6.828ZM4.586 7l-.056.055A2 2 0 0 0 3 9v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2h-4a5 5 0 0 1 0-10h4a2 2 0 0 0-1.53-1.945L17.414 7H4.586Z"
                    clip-rule="evenodd" />
            </svg>

            <p class="text-xl text-slate-800 font-bold dark:text-slate-200 ml-3">
                {{ $user->balance }} ₽
            </p>

            <a href="{{ route('order.create') }}"
                class="ml-4 min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">+</a>
        </div>

        @if ($user->tariff)
            <div class="flex items-end text-slate-600 dark:text-slate-400">
                <span
                    class="text-slate-800 dark:text-slate-200 font-bold text-xl">{{ round($user->tariff->price) }}</span>/{{ __('day') }}
            </div>
        @endif
    </div>
</x-profile.section>
