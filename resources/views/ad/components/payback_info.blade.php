<div class="mt-2 sm:mt-3 grid grid-cols-1 xs:grid-cols-2 gap-2 sm:gap-4" x-data="{
    paybackMonths: '{{ $profit - $expense * $tariff > 0 ? $price / ($profit - $expense * $tariff) : '∞' }}',
    profit: {{ $profit }},
    expense: {{ $expense }},
    tariff: {{ $tariff }}
}">
    <div class="px-3 py-2 xs:px-4 xs:py-3 sm:p-4 lg:p-5 rounded-2xl relative bg-slate-900 dark:bg-slate-800 shadow-xl overflow-hidden">
        <div class="relative z-10">
            <span class="text-slate-400 text-xxs sm:text-xs font-bold uppercase tracking-widest">{{ __('Profit per day') }}</span>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-xl sm:text-3xl font-black"
                    :class="profit - expense * tariff > 1 ? 'text-emerald-400' : 'text-red-400'">
                    {{ number_format($profit, 2, '.', ' ') }}
                </span>
                <span class="font-bold"
                    :class="profit - expense * tariff > 1 ? 'text-emerald-500/50' : 'text-red-500/50'">USDT</span>
            </div>
            <p class="text-slate-400 text-xs mt-1 sm:mt-2">≈ {{ number_format($profit / $rub, 2) }} ₽</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 opacity-20">
            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 80, 40 90, 50 60 C 60 30, 80 40, 100 0 V 100 H 0 Z"
                    fill="url(#grad_{{ $expense }})" />
                <defs>
                    <linearGradient id="grad_{{ $expense }}" x1="0%" y1="0%" x2="0%"
                        y2="100%">
                        <stop offset="0%" style="stop-color:rgb(16, 185, 129);stop-opacity:1" />
                        <stop offset="100%" style="stop-color:rgb(16, 185, 129);stop-opacity:0" />
                    </linearGradient>
                </defs>
            </svg>
        </div>
    </div>

    <div
        class="px-3 py-2 xs:px-4 xs:py-3 sm:p-4 lg:p-5 rounded-2xl bg-white dark:bg-slate-300 border border-slate-300 dark:border-slate-700 shadow-sm overflow-hidden">
            <span class="text-slate-500 text-xxs sm:text-xs font-bold uppercase tracking-widest">Окупаемость</span>
            <div class="mt-2">
                <span class="text-xl sm:text-3xl font-black text-slate-800"
                    x-text="paybackMonths != '∞' ? paybackMonths != 0 ? Math.round(paybackMonths) : '{{ __('No data') }}' : '∞'"></span>
                @if ($price != 0)
                    <span class="text-slate-400 font-bold text-lg">{{ __('d') }}.</span>
                @endif
            </div>
            @if ($price != 0)
                <div class="mt-1 sm:mt-1.5 w-fit px-2 py-0.5 rounded text-xxs font-bold uppercase tracking-tighter"
                    :class="{
                        'bg-red-100 text-red-700': paybackMonths > 1460 || paybackMonths == '∞',
                        'bg-amber-100 text-amber-700': paybackMonths > 730 && paybackMonths <= 1460,
                        'bg-emerald-100 text-emerald-700': paybackMonths <= 730,
                    }">
                    <span
                        x-text="paybackMonths != '∞' ? paybackMonths <= 730 ? '{{ __('Top payback') }}' : (paybackMonths <= 1460 ? '{{ __('Normal') }}' : '{{ __('Long payback period') }}') : '{{ __('WOW') }}'"></span>
                </div>
            @endif
    </div>
</div>
