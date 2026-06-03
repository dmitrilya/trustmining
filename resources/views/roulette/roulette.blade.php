<div x-data="roulette({{ $roulettePrizes }}, {{ $timeToSpin }})">
    <x-modal name="roulette" maxWidth="sm" rounded="rounded-xl">
        <div class="p-2 xs:p-4 sm:p-6" x-init="$watch('isSpinning', value => { if (!value && wonPrize) $dispatch('close'); })">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-2xl font-black text-slate-800 dark:text-slate-200 tracking-tight">
                    {{ __('Try your luck') }}</h2>

                <button type="button" aria-label="{{ __('Close') }}"
                    class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                    @click="$dispatch('close'); closeRoulette()">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-8">
                {{ __('Just spin the wheel and win real prizes') }}
                {{ trans_choice('time.period_choice', config('settings.roulette.period'), ['count' => config('settings.roulette.period')]) }}
            </p>

            <div class="relative w-64 xs:w-80 h-64 xs:h-80 mx-auto mb-8 flex items-center justify-center">
                <div
                    class="absolute -top-3 left-1/2 -translate-x-1/2 z-30 w-0 h-0 border-l-[15px] border-l-transparent border-r-[15px] border-r-transparent border-t-[25px] border-t-slate-300 dark:border-t-slate-700 drop-shadow-[0_2px_5px_rgba(0,0,0,0.5)]">
                </div>

                <div class="w-full h-full rounded-full border-4 border-slate-300 dark:border-slate-700 overflow-hidden shadow-inner relative transition-transform duration-[5000ms] ease-out z-10"
                    :style="`transform: rotate(${currentRotation}deg); background: conic-gradient(${prizes.map((p, i) => `${i % 2 === 0 ? 'oklch(96.8% 0.007 247.896)' : 'oklch(20.8% 0.042 265.755)'} ${i * sectorAngle}deg ${(i + 1) * sectorAngle}deg`).join(', ')})`">

                    <template x-for="(prize, index) in prizes" :key="prize.id">
                        <div class="absolute top-0 left-0 w-full h-full origin-center flex justify-center pointer-events-none"
                            :style="`transform: rotate(${(index * sectorAngle) + (sectorAngle / 2)}deg)`">

                            <div
                                class="absolute top-4 xs:top-5 w-[88px] xs:w-28 h-20 xs:h-[104px] flex flex-col items-center justify-between origin-center">
                                <span class="font-black uppercase tracking-wider select-none text-center max-w-full text-xxs xs:text-xs"
                                    :class="[
                                        index % 2 === 0 ? 'text-slate-800' : 'text-slate-200',
                                    ]"
                                    x-text="prize.name">
                                </span>
                                <div class="flex flex-col items-center">
                                    <a class="mb-1 w-9 h-9 xs:w-12 xs:h-12 rounded-full overflow-hidden hover:ring ring-indigo-600 pointer-events-auto z-20"
                                        :href="prize.partner_link" target="_blank"
                                        :aria-label="`${prize.name} partner link`">
                                        <img class="w-full"
                                            :src="prize?.id != 3 ? `/storage/${prize.user.company.logo}` : '/img/hf_logo.webp'"
                                            :alt="`${prize.name} icon`">
                                    </a>
                                    <span class="text-xxs"
                                        :class="[
                                            index % 2 === 0 ? 'text-slate-600' : 'text-slate-400',
                                        ]"
                                        x-text="prize.chance + '%'"></span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-10 h-10 bg-slate-900 border-2 border-slate-700 dark:border-slate-300 rounded-full z-20 shadow-lg">
                    </div>
                </div>
            </div>

            <button
                class="w-full items-center px-4 py-2.5 bg-primary-gradient rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:opacity-90 focus:outline-none focus:opacity-90 transition-all disabled:cursor-not-allowed shadow-lg"
                @click="spinWheel" :disabled="isSpinning || timeToSpin > 0">

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
            <a class="w-20 h-20 rounded-full overflow-hidden hover:ring ring-indigo-600 mb-3"
                :href="wonPrize?.partner_link">
                <img class="w-full"
                    :src="wonPrize?.id != 3 ? `/storage/${wonPrize?.user.company.logo}` : '/img/hf_logo.webp'"
                    :alt="`${wonPrize?.name} icon`">
            </a>
            <p class="text-indigo-500 mb-2 font-bold" x-text="wonPrize?.name">
            </p>
            <p class="text-sm text-slate-600 dark:text-slate-400" x-text="wonPrize?.caption">
            </p>

            @auth
                <template x-if="wonPrize?.name != '{{ config('settings.roulette.extra_spin_name') }}'">
                    <a :href="wonPrize?.href"
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
