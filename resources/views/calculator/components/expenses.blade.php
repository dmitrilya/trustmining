<div class="mt-2 md:mt-mt-4 mb-4">
    <x-input-label for="tariff" :value="__('Tariff')" />
    <x-text-input ::value="tariff" id="tariff" type="text"
        @input="tariff = filterDouble($el, 0, 20, 2);$el.value = tariff" />
</div>

<div x-data="{ show: true }" class="border-y border-gray-300 dark:border-zinc-700">
    <div>
        <h4>
            <button type="button" @click="show = !show"
                class="flex items-center justify-between w-full py-2 sm:py-3 text-left rtl:text-right text-gray-800 dark:text-gray-200 text-xs sm:text-sm">
                <span>{{ __('Additional settings') }}</span>
                <svg class="size-2 shrink-0" :class="{ 'rotate-180': !show }" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
            </button>
        </h4>
        <div x-show="show" style="display: none">
            <div class="py-3">
                <div class="space-y-2 md:space-y-4">
                    <div class="flex space-x-2 sm:space-x-3">
                        <div class="w-full">
                            <x-input-label for="fee" :value="__('Pool fee')" />
                            <x-text-input ::value="fee" id="fee" type="text"
                                @input="fee = filterDouble($el, 0, 100, 2);$el.value = fee" />
                        </div>

                        <div class="w-full">
                            <x-input-label for="uptime" :value="__('Uptime') . ' (%)'" />
                            <x-text-input ::value="uptime" id="uptime" type="text"
                                @input="uptime = filterDouble($el, 0, 100, 2);$el.value = uptime" />
                        </div>
                    </div>

                    {{-- <div>
                        <x-input-label for="difficulty-growth" :value="__('Annualized difficulty growth') . ' (%)'" />
                        <x-text-input ::value="difficultyGrowth" id="difficulty-growth" type="text"
                            @input="difficultyGrowth = filterDouble($el, -20, 120, 2);$el.value = difficultyGrowth" />
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
