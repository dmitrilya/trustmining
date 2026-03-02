<div class="mt-2 sm:mt-3 grid grid-cols-1 xs:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-2 sm:gap-4" x-data="{
    paybackMonths: {{ $profit > 0 ? $ad->price * $ad->coin->rate / $profit : '∞' }},
    dailyProfit: {{ $profit }}
}">
    <div class="relative overflow-hidden p-5 rounded-2xl bg-slate-900 dark:bg-zinc-800 text-white shadow-xl">
        <div class="relative z-10">
            <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">{{ __('Profit per day') }}</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-black text-emerald-400">
                    {{ number_format($profit, 2, '.', ' ') }}
                </span>
                <span class="text-emerald-500/50 font-bold">USDT</span>
            </div>
            <p class="text-gray-400 text-xs mt-1">≈ {{ number_format($profit / $rub, 2) }} ₽</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 80, 40 90, 50 60 C 60 30, 80 40, 100 0 V 100 H 0 Z" fill="url(#grad)" />
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:rgb(16, 185, 129);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgb(16, 185, 129);stop-opacity:0" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    <div class="p-5 rounded-2xl bg-white dark:bg-zinc-950 border border-gray-300 dark:border-zinc-700 shadow-sm flex items-center justify-between">
        <div>
            <span class="text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-widest">Окупаемость</span>
            <div class="mt-2">
                <span class="text-3xl font-black text-gray-800 dark:text-gray-200" x-text="(paybackMonths / 12).toFixed(1)"></span>
                <span class="text-gray-400 font-bold text-lg">г.</span>
            </div>
            <!-- Бейдж статуса -->
            <div class="mt-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-tighter"
                :class="{
                    'bg-emerald-100 text-emerald-700': paybackMonths <= 24,
                    'bg-amber-100 text-amber-700': paybackMonths > 24 && paybackMonths <= 48,
                    'bg-red-100 text-red-700': paybackMonths > 48
                }">
                <span
                    x-text="paybackMonths <= 24 ? 'Топ окупаемость' : (paybackMonths <= 48 ? 'В норме' : 'Долгая окупаемость')"></span>
            </div>
        </div>
    </div>
</div>
