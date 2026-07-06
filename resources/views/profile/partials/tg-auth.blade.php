<section class="space-y-6">
    <header>
        <h2 class="text-lg text-slate-800 dark:text-slate-200 mb-2">
            {{ __('Telegram authorization') }}
        </h2>

        @if (!$user->tg_id)
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ __('You can log in using Telegram to receive notifications from our bot') }}
            </p>
        @else
            <p class="text-sm text-slate-600 dark:text-slate-400">
                {{ __('You are logged in. Notifications will come from the official telegram bot') }}
            </p>
        @endif
    </header>

    <x-tg-auth />
</section>
