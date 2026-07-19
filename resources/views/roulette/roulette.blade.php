<div x-data="roulette({{ $roulettePrizes }}, {{ $timeToSpin }})">
    <x-modal name="roulette" maxWidth="2xl" rounded="rounded-xl">
        <div class="p-2 xs:p-4 sm:p-6" x-init="$watch('isSpinning', value => { if (!value && wonPrize) $dispatch('close'); })">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-200 tracking-tight">
                    {{ __('Try your luck') }}</h2>

                <button type="button" aria-label="{{ __('Close') }}"
                    class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                    @click="$dispatch('close'); closeRoulette()">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-8">
                {{ __('Just spin the wheel and win real prizes') }}
                {{ trans_choice('time.period_choice', config('settings.roulette.period'), ['count' => config('settings.roulette.period')]) }}
            </p>

            <div class="relative w-full mb-8 select-none">
                <div
                    class="absolute -top-1 left-1/2 -translate-x-1/2 z-30 w-0 h-0  border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-t-[14px] border-t-indigo-500 drop-shadow-[0_0_8px_rgba(99,102,241,0.9)]">
                </div>

                <div
                    class="absolute -bottom-1 left-1/2 -translate-x-1/2 z-30 w-0 h-0 border-l-[8px] border-l-transparent border-r-[8px] border-r-transparent border-b-[14px] border-b-indigo-500 drop-shadow-[0_0_8px_rgba(99,102,241,0.9)]">
                </div>

                <div
                    class="w-full h-40 ring ring-inset ring-indigo-500 relative overflow-hidden rounded-2xl shadow-[inset_0_4px_20px_rgba(0,0,0,0.2)] flex items-center">
                    <div class="absolute top-0 left-0 w-12 h-full bg-gradient-to-r from-slate-200 dark:from-slate-950 to-transparent z-20">
                    </div>
                    <div class="absolute top-0 right-0 w-12 h-full bg-gradient-to-l from-slate-200 dark:from-slate-950 to-transparent z-20">
                    </div>

                    <div
                        class="absolute left-1/2 top-0 -translate-x-1/2 w-[1px] h-full bg-indigo-500 z-20 pointer-events-none shadow-[0_0_6px_rgba(99,102,241,0.4)]">
                    </div>

                    <div class="flex items-center gap-2 px-4 transition-transform duration-[5000ms] ease-out will-change-transform h-full"
                        :style="`transform: translateX(${currentTranslateX}px);`" id="roulette-tape">

                        <template x-for="(prize, index) in extendedPrizes" :key="index">
                            <div class="w-28 h-32 flex-shrink-0 flex flex-col items-center justify-between px-2 py-4 rounded-xl border relative transition-all duration-300 overflow-hidden"
                                :class="getPrizeRarityClasses(prize.chance).card">
                                <x-card-pattern ::style="`--pattern-color: ${getPrizeRarityClasses(prize.chance).patternColor}`" />

                                <div class="absolute inset-0 bg-gradient-to-b from-white/10 dark:from-white/[0.02] to-transparent pointer-events-none"></div>

                                <div class="absolute top-0 left-0 w-full h-1" :class="getPrizeRarityClasses(prize.chance).badge.split(' ')"></div>

                                <span :class="prize.isLongTitle ? 'text-xxs' : 'text-xxs xs:text-xs'"
                                    class="font-extrabold uppercase tracking-tight select-none text-center max-w-full text-slate-800 dark:text-slate-200 leading-tight z-10"
                                    x-text="prize.name">
                                </span>

                                <div class="w-10 h-10 rounded-full overflow-hidden border border-slate-300 dark:border-slate-700 relative"
                                    :class="getPrizeRarityClasses(prize.chance).glow">
                                    <img class="w-full h-full object-contain" :src="`/storage/${prize.user.company.logo}`" :alt="`${prize.name} icon`">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="mt-4 mb-6">
                <div class="text-xxs xs:text-xs font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 mb-4 xs:mb-6 text-center">
                    {{ __('Prizes provided by partners') }}
                </div>

                <div class="grid grid-cols-3 xs:grid-cols-4 md:grid-cols-6 justify-items-center gap-3 xs:gap-4">
                    <template x-for="prize in prizes" :key="prize.id">
                        <a class="flex flex-col items-center relative group" :href="prize.partner_link" target="_blank"
                            :aria-label="`${prize.name} partner link`">
                            <img class="w-12 h-12 xs:w-16 xs:h-16 rounded-full group-hover:ring ring-indigo-600 pointer-events-auto"
                                :src="`/storage/${prize.user.company.logo}`" :alt="`${prize.name} icon`">
                            <div class="text-center mt-1 xs:mt-2 text-xs sm:text-sm text-slate-800 dark:text-slate-200" x-text="prize.user.name"></div>
                            <div
                                class="pointer-events-none absolute bottom-full left-1/2 -translate-x-1/2 mb-2 hidden group-hover:block bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-200 text-xs font-bold py-1 px-2 xs:py-1.5 xs:px-3 rounded-md shadow-md whitespace-nowrap z-50">
                                <span x-text="prize.name"></span>
                            </div>
                        </a>
                    </template>
                </div>
            </div>

            <button
                class="w-full items-center px-4 py-2.5 bg-primary-gradient rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:opacity-90 transition-all disabled:cursor-not-allowed shadow-lg"
                @click="spinTape" :disabled="isSpinning || timeToSpin > 0">

                <span x-show="isSpinning" class="animate-pulse">{{ __('The wheel is spinning') }}...</span>
                <span x-show="!isSpinning && timeToSpin === 0">{{ __('Spin') }}</span>
                <span x-show="!isSpinning && timeToSpin > 0" class="font-mono">
                    {{ __('Available via') }}: <span x-text="formattedTime"></span>
                </span>
            </button>
        </div>
    </x-modal>

    <x-modal name="roulette_prize" maxWidth="xs" rounded="rounded-xl">
        <div class="p-6 flex flex-col items-center text-center">
            <div class="text-4xl mb-3">🎉</div>
            <h3 class="text-2xl font-extrabold text-slate-800 dark:text-slate-200 mb-6">
                {{ __('Congratulations!') }}
            </h3>
            <a class="w-20 h-20 rounded-full overflow-hidden hover:ring ring-indigo-600 mb-3" :href="wonPrize?.partner_link">
                <template x-if="wonPrize">
                    <img class="w-full" :src="`/storage/${wonPrize.user.company.logo}`" :alt="`${wonPrize.name} icon`">
                </template>
            </a>
            <p class="text-indigo-500 mb-2 font-bold" x-text="wonPrize?.name">
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400" x-text="wonPrize?.caption">
            </p>

            @auth
                <template x-if="wonPrize?.name != '{{ config('settings.roulette.extra_spin_name') }}'">
                    <a target="_blank" :href="wonPrize?.href"
                        class="mt-8 w-full px-4 py-2.5 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border-0 ring-1 ring-inset ring-slate-200 dark:ring-slate-700 rounded-lg font-bold text-xs text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow-[0_0_8px_rgba(64,64,153,0.15)] dark:shadow-[0_0_12px_rgba(64,255,159,0.12)] hover:shadow-[0_0_10px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_15px_rgba(64,255,159,0.35)] focus:outline-none disabled:opacity-25 transition ease-in-out duration-100">
                        {{ __('Take the prize') }}
                    </a>
                </template>
            @else
                <p class="text-xs text-slate-500 mt-8 mb-2">
                    {{ __('Login to claim your prize') }}
                </p>
                <button
                    class="w-full px-4 py-2.5 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 border-0 ring-1 ring-inset ring-slate-200 dark:ring-slate-700 rounded-lg font-bold text-xs text-slate-800 dark:text-slate-200 uppercase tracking-widest shadow-[0_0_8px_rgba(64,64,153,0.15)] dark:shadow-[0_0_12px_rgba(64,255,159,0.12)] hover:shadow-[0_0_10px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_15px_rgba(64,255,159,0.35)] focus:outline-none disabled:opacity-25 transition ease-in-out duration-100"
                    @click="$dispatch('close');$dispatch('open-modal', 'login')">
                    {{ __('Login') }}
                </button>
            @endauth
        </div>
    </x-modal>
</div>
