<template x-if="version !== null">
    <div class="mt-8 sm:mt-10">
        @if (!$widjet)
            <div class="mt-6">
                <h2 class="sr-only">{{ __('Reviews') }}</h2>
                <div class="flex items-center">
                    <x-rating></x-rating>

                    <a :href="`/asic-miners/${version.bs}/${version.ns}/reviews`" class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">
                        <span x-text="version.r"></span>
                        <span
                            x-text="window.pluralize(version.r, ['{{ trans_choice('navigation.reviews', 1) }}', '{{ trans_choice('navigation.reviews', 2) }}', '{{ trans_choice('navigation.reviews', 5) }}'])"></span>
                    </a>
                </div>
            </div>
        @endif
        <div class="mt-3 xs:mt-4 sm:mt-5 space-y-1 sm:space-y-1.5 md:space-y-2" style="min-height: 120px">
            <x-characteristics.characteristics>
                <x-characteristics.characteristic name="Algorithm" x-value="algorithms[version.a].n" />
                <x-characteristics.characteristic name="Efficiency" x-value="version.e + ' j/' + version.m" />
                <x-characteristics.characteristic name="Power" x-value="Math.round(version.e * version.h) + ' {{ __('W') }}'" />
                @if (!$widjet)
                    <x-characteristics.characteristic name="The best price" x-value="version.p ? version.p + ' USDT' : '{{ __('No data') }}'" />
                @endif
                <x-characteristics.characteristic name="USDTRUB" :value="round(1 / $rub, 2)" />
            </x-characteristics.characteristics>
            @if (!$widjet)
                <a class="block mt-6 ml-auto w-fit text-xs xs:text-sm text-indigo-500 hover:text-indigo-600"
                    x-bind:href="version ?
                        `/asic-miners/${version.bs}/${version.ns}/${version.h}${version.m}` :
                        '#'">
                    {{ __('All characteristics') }}
                </a>
            @endif
        </div>

        @if (!$widjet)
            <template x-if="version.ac">
                <a class="mt-3 xs:mt-4 sm:mt-5 w-fit" x-bind:href="version ? '/ads/miners?model=' + version.ns : ' # '">
                    <x-buttons.primary-button class="text-xxs xs:text-xs">{{ __('Find ads') }}</x-buttons.primary-button>
                </a>
            </template>
        @endif
    </div>
</template>
