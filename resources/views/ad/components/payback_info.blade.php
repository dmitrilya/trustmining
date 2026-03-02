<div class="mt-2 sm:mt-3 grid grid-cols-1 xs:grid-cols-2 md:grid-cols-1 lg:grid-cols-2 gap-2 sm:gap-4"
    x-data="{
        paybackMonths: '{{ $profit - $expense * $tariff > 0 ? ($ad->price * $ad->coin->rate) / ($profit - $expense * $tariff) : '∞' }}',
        profit: {{ $profit }},
        expense: {{ $expense }},
        tariff: {{ $tariff }}
    }">
    <div class="p-3 xs:p-4 sm:p-5 rounded-2xl relative bg-slate-900 dark:bg-slate-800 shadow-xl overflow-hidden">
        <div class="relative z-10">
            <span class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ __('Profit per day') }}</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-black"
                    :class="profit - expense * tariff > 1 ? 'text-emerald-400' : 'text-red-400'">
                    {{ number_format($profit, 2, '.', ' ') }}
                </span>
                <span class="font-bold"
                    :class="profit - expense * tariff > 1 ? 'text-emerald-500/50' : 'text-red-500/50'">USDT</span>
            </div>
            <p class="text-slate-400 text-xs mt-1">≈ {{ number_format($profit / $rub, 2) }} ₽</p>
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

    <div
        class="p-3 xs:p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-100 border border-slate-300 dark:border-slate-700 shadow-sm flex items-center justify-between overflow-hidden">
        <div>
            <span class="text-slate-500 text-xs font-bold uppercase tracking-widest">Окупаемость</span>
            <div class="mt-2">
                <span class="text-3xl font-black text-slate-800"
                    x-text="paybackMonths != '∞' ? Math.round(paybackMonths) : '∞'"></span>
                <span class="text-slate-400 font-bold text-lg">{{ __('d') }}.</span>
            </div>
            <div class="mt-2 inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-tighter"
                :class="{
                    'bg-red-100 text-red-700': paybackMonths > 48 || paybackMonths == '∞',
                    'bg-amber-100 text-amber-700': paybackMonths > 24 && paybackMonths <= 48,
                    'bg-emerald-100 text-emerald-700': paybackMonths <= 24,
                }">
                <span
                    x-text="paybackMonths != '∞' ? paybackMonths <= 24 ? 'Топ окупаемость' : (paybackMonths <= 48 ? 'В норме' : 'Долгая окупаемость') : 'Окак'"></span>
            </div>
        </div>
    </div>
</div>
