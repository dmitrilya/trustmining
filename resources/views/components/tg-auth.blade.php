<div x-data="{ tgWidgetLoaded: false, tgTimeout: false }" x-init="setTimeout(() => {
    if (window.Telegram && window.Telegram.Login) tgWidgetLoaded = true;
    tgTimeout = true;
}, 2500);"
    class="relative min-h-[40px]">
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

    <div x-show="tgWidgetLoaded" x-transition style="display: none">
        <button type="button"
            class="ml-auto flex items-center justify-center px-4 py-2.5 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border-0 ring-1 ring-inset ring-slate-200 dark:ring-slate-700 rounded-lg font-bold text-xs text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow-[0_0_8px_rgba(64,64,153,0.15)] dark:shadow-[0_0_12px_rgba(64,255,159,0.12)] hover:shadow-[0_0_10px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_15px_rgba(64,255,159,0.35)] focus:outline-none disabled:opacity-25 transition ease-in-out duration-150"
            @click="Telegram.Login.auth({ bot_id: '{{ config('services.tgbot.id') }}', request_access: true },  (data) => {
                if (data) {
                    let query = Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&');
                    window.location.href = 'https://trustmining.ru/tg/auth?' + query;
                } else {
                    console.error('Telegram auth failed or closed');
                }
            });">
            <svg class="size-4 mr-2 fill-current" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-1-.65-.35-1 .22-1.62.15-.15 2.7-2.46 2.75-2.67.01-.03.01-.14-.06-.2-.07-.06-.17-.04-.24-.02-.1.02-1.63 1.03-4.61 3.05-.44.3-.84.45-1.19.44-.39-.01-1.14-.22-1.7-.4-.68-.22-1.22-.34-1.17-.73.03-.2.31-.4.85-.62 3.32-1.44 5.54-2.4 6.66-2.87 3.17-1.31 3.83-1.54 4.26-1.55.09 0 .31.02.45.14.12.1.15.24.16.34-.01.06 0 .14-.01.22z" />
            </svg>
            <span>{{ __('Login via Telegram') }}</span>
        </button>
    </div>
</div>
