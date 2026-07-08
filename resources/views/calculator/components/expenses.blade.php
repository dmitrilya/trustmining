<div class="flex space-x-2 sm:space-x-3 mt-3 xs:mt-4 mb-4">
    <div class="w-full">
        <x-inputs.input-label for="tariff" :value="__('Tariff')" />
        <x-inputs.text-input ::value="tariff" id="tariff" type="text"
            @input="tariff = filterDouble($el, 0, 20, 2);$el.value = tariff" />
    </div>

    <div class="w-full">
        <div class="flex items-center">
            <x-inputs.input-label for="fee" :value="__('Pool fee')" />

            <template x-if="version && algorithms[version.a].p[profitNumber].c[0].a == 'BTC'">
                <div class="relative" x-data="{ open: false }" @mouseover="open = true" @mouseover.away = "open = false"
                    @click="open = !open" @click.away="open = false">
                    <div class="ml-1 sm:ml-2 text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5"
                                d="M9.529 9.988a2.502 2.502 0 1 1 5 .191A2.441 2.441 0 0 1 12 12.582V14m-.01 3.008H12M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>

                    <div x-show="open" style="display: none"
                        class="absolute w-40 top-5 right-0 px-2 py-3 sm:px-4 sm:py-5 bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl z-20">
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                            {{ __('The commission is indicated when working on a mining pool') }} <a
                                href="{{ config('partners.headframe.link') }}"
                                class="inline font-bold text-indigo-500 hover:text-indigo-600 under" target="_blank">HeadFrame
                                (0.9%)</a></p>
                    </div>
                </div>
            </template>
        </div>
        <x-inputs.text-input ::value="fee" id="fee" type="text"
            @input="fee = filterDouble($el, 0, 100, 2);$el.value = fee" />
    </div>
</div>

@if (in_array('additional-params', $blocks))
    <div class="border-y border-slate-300 dark:border-slate-700">
        <div x-data="{ show: window.innerWidth > 640 }">
            <button type="button" @click="show = !show"
                class="flex items-center justify-between w-full px-0.5 py-2 sm:py-3 text-left text-slate-800 dark:text-slate-200 text-xs sm:text-sm">
                <span>{{ __('Additional settings') }}</span>
                <svg class="w-2 h-2 shrink-0" :class="{ 'rotate-180': !show }" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
            <div x-show="show" style="display: none">
                <div class="py-3">
                    <div class="space-y-2 md:space-y-3">
                        <div class="flex space-x-2 sm:space-x-3">
                            <div class="w-full">
                                <x-inputs.input-label for="count" :value="__('Count')" />
                                <x-inputs.text-input ::value="count" id="count" type="text"
                                    @input="count = filterDouble($el, 1, 10000, 0);$el.value = count" />
                            </div>

                            <div class="w-full">
                                <x-inputs.input-label for="uptime" :value="__('Uptime') . ' (%)'" />
                                <x-inputs.text-input ::value="uptime" id="uptime" type="text"
                                    @input="uptime = filterDouble($el, 0, 100, 2);$el.value = uptime" />
                            </div>
                        </div>

                        {{-- <div>
                        <x-inputs.input-label for="difficulty-growth" :value="__('Annualized difficulty growth') . ' (%)'" />
                        <x-inputs.text-input ::value="difficultyGrowth" id="difficulty-growth" type="text"
                            @input="difficultyGrowth = filterDouble($el, -20, 120, 2);$el.value = difficultyGrowth" />
                    </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
