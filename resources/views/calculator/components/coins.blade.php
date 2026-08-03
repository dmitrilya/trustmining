<h2 class="text-xs xs:text-sm text-slate-800 dark:text-slate-200 mt-6 sm:mt-7 lg:mt-8">
    {{ __('How many coins does it mine per day') }}</h2>

<template x-for="(profit, i) in algorithms[version?.a].p" :key="'profit_' + i">
    <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer" @click="profitNumber = i, fee = profit.c[0].f;">
        <x-inputs.radio name="profitNumber" ::value="i" ::checked="profitNumber == i" ::aria-label="`{{ __('Change calculation to') }} ${profit.c[0].n}`" />

        <template x-for="coin in profit.c" :key="coin.a">
            <div>
                <div class="flex items-center">
                    <img :src="`/storage/coins/${coin.a}.webp`" :alt="'{{ __('Calculator') }} ' + coin.n" class="w-5 xs:w-6 mr-1 xs:mr-2">
                    <div>
                        <div class="text-xs xs:text-sm text-slate-600 dark:text-slate-400" x-text="coin.a">
                        </div>
                        <div class="text-xxs xs:text-xs text-slate-500" x-text="coin.n">
                        </div>
                    </div>
                </div>
                <div class="text-xxs xxs:text-xs text-slate-800 dark:text-slate-200 font-bold mt-0.5 xs:mt-1"
                    x-text="version ? Math.round(version.h * coin.p * version.c * 100000000) / 100000000 : 0">
                </div>
            </div>
        </template>
    </div>
</template>
