<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Telegram authorization') }}
        </h2>
    </header>

    @if (!$user->tg_id)
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('You can log in using Telegram to receive notifications from our bot') }}
        </p>
    @else
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('You are logged in. Notifications will come from the official telegram bot') }}
        </p>
    @endif

    <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="trust_m_notifications_bot"
        data-size="medium" data-radius="6" data-auth-url="https://trustmining.ru/tg/auth" data-request-access="write">
    </script>
</section>
