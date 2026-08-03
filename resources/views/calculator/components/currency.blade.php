<div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
    <h2 class="text-xs xs:text-sm text-slate-800 dark:text-slate-200">
        {{ __('Profit calculation') }}</h2>
    <div class="flex cursor-pointer mx-3">
        <button
            :class="{
                'bg-primary-gradient text-white': currency ==
                    'RUB',
                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-200': currency ==
                    'USDT'
            }"
            class="p-1 xs:p-1.5 rounded-l-md border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
            @click="currency = 'RUB'">RUB</button>
        <button
            :class="{
                'bg-primary-gradient text-white': currency ==
                    'USDT',
                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-200': currency ==
                    'RUB'
            }"
            class="p-1 xs:p-1.5 rounded-r-md border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
            @click="currency = 'USDT'">USDT</button>
    </div>
</div>
