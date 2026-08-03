<div style="min-height: 228px" class="space-y-2 sm:space-y-4">
    <div class="flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full max-w-xs mx-auto">
        <button @click="view = 'day'" :class="view === 'day' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
            class="flex-1 py-1.5 text-xs text-slate-600 dark:text-slate-400 font-bold rounded-lg transition-all">{{ __('Day') }}</button>
        <button @click="view = 'month'" :class="view === 'month' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
            class="flex-1 py-1.5 text-xs text-slate-600 dark:text-slate-400 font-bold rounded-lg transition-all">{{ __('Month') }}</button>
        <button @click="view = 'year'" :class="view === 'year' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
            class="flex-1 py-1.5 text-xs text-slate-600 dark:text-slate-400 font-bold rounded-lg transition-all">{{ __('Year') }}</button>
    </div>

    <div>
        <div class="text-center">
            <span class="text-slate-500 text-sm tracking-wide">{{ __('Net Profit') }}</span>
            <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 dark:text-slate-200 mt-1"
                x-text="dailyProfit + (currency == 'RUB' ? ' ₽' : ' USDT')">
            </div>
        </div>

        @if ($firmwares->count())
            <template x-if="firmwares.filter(firmware => firmware.v == version.i).length && (firmware != null || firmwareUp > 0)">
                <div class="w-fit mx-auto mt-2 px-2 py-1 rounded-lg bg-indigo-500/10 text-indigo-500 border-indigo-500 text-xs">
                    <span
                        x-text="firmware == null ? `+${firmwareUp}% {{ __('with firmware (enable in advanced settings)') }}` : '{{ __('The :hashrate firmware from :company was selected') }}'.replace(':hashrate', firmware.h + firmware.m + '/s').replace(':company', firmware.c)"></span>
                </div>
            </template>
        @endif

        <div class="mt-6">
            <div class="flex justify-between text-xs font-extrabold uppercase">
                <span class="text-emerald-500">{{ __('Income') }}</span>
                <span class="text-red-700 dark:text-red-500">{{ __('Expense') }}</span>
                <template x-if="taxEnabled">
                    <span class="text-rose-600 dark:text-rose-400">{{ __('Tax') }}</span>
                </template>
            </div>
            <div class="mt-2 h-1 sm:h-2 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden flex">
                <div class="h-full bg-emerald-500 transition-all duration-500" :style="`width: ${incPercent}%`"></div>
                <div class="h-full bg-red-600 transition-all duration-500" :style="`width: ${expPercent}%`"></div>
                <template x-if="taxEnabled">
                    <div class="h-full bg-rose-500 transition-all duration-500" :style="`width: ${taxPercent}%`"></div>
                </template>
            </div>
            <div class="mt-3 flex justify-between text-sm sm:text-base lg:text-lg font-black text-slate-800 dark:text-slate-200">
                <span x-text="dailyIncome"></span>
                <span x-text="dailyConsumption"></span>
                <template x-if="taxEnabled">
                    <span x-text="dailyTax"></span>
                </template>
            </div>
        </div>

        <template x-if="taxEnabled">
            <div class="mt-6 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl p-2 sm:p-4 shadow-md shadow-logo-color">
                <div class="text-slate-500 text-sm tracking-wide mb-2 text-center">{{ __('Tax calculation') }} {{ __('per day') }}</div>
                <div class="font-mono text-slate-800 dark:text-slate-200 text-xxs xxs:text-xs sm:text-sm tracking-tight" x-html="taxHelp">
                </div>
                <div class="mt-2 text-xxs text-slate-500">*{{ __('Tax calculation can be disabled in additional settings') }}</div>
            </div>
        </template>
    </div>
</div>
