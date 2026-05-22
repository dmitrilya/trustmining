<section class="space-y-6">
    <header>
        <h2 class="text-lg text-slate-950 dark:text-slate-50 mb-2">
            {{ __('Telegram authorization') }}
        </h2>

        @if (!$user->tg_id)
            <p class="text-sm text-slate-700 dark:text-slate-400">
                {{ __('You can log in using Telegram to receive notifications from our bot') }}
            </p>
        @else
            <p class="text-sm text-slate-700 dark:text-slate-400">
                {{ __('You are logged in. Notifications will come from the official telegram bot') }}
            </p>
        @endif
    </header>

    <div x-data="{ tgWidgetLoaded: false, tgTimeout: false }" x-init="setTimeout(() => { if (!tgWidgetLoaded) tgTimeout = true; }, 2500);"
        class="relative min-h-[40px] flex flex-col items-center justify-center">

        <div x-show="tgTimeout && !tgWidgetLoaded" x-transition
            class="text-center p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl max-w-xs" x-cloak>
            <p class="text-xs font-medium text-amber-600 dark:text-amber-400">
                ⚠️ <strong>{{ __('Attention') }}:</strong>
                {{ __('To authorize via Telegram in the Russian Federation, you must enable') }}
                <strong>VPN</strong>.
            </p>
        </div>

        <div x-show="!tgWidgetLoaded && !tgTimeout" class="text-xs text-slate-400 animate-pulse">
            {{ __('Loading authorization') }}...
        </div>

        <div :class="tgWidgetLoaded ? 'opacity-100 scale-100' : 'opacity-0 scale-95 fixed pointer-events-none'"
            class="transition-all duration-300 flex justify-center items-center">
            <script async src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="trust_m_notifications_bot"
                data-size="medium" data-radius="6" data-auth-url="https://trustmining.ru/tg/auth" data-request-access="write"
                @load="tgWidgetLoaded = true;"></script>
        </div>
    </div>
</section>
