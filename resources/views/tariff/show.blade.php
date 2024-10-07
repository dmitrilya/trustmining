<x-app-layout>
    <div class="bg-gray-900 h-128 lg:h-144 xl:h-160 relative z-10 overflow-hidden">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8 py-8 relative">
            <div class="mt-4 md:mt-6 lg:mt-8 xl:mt-10 py-4 sm:py-6 lg:py-8 mb-4 sm:mb-6 lg:mb-8 text-center">
                <div
                    class="text-white font-semibold text-lg sm:text-xl md:text-3xl lg:text-4xl xl:text-5xl mb-2 sm:mb-4 lg:mb-6">
                    {{ __('Pricing plans for teams of all sizes') }}</div>
                <div class="max-w-2xl mx-auto text-gray-300 sm:text-lg lg:text-xl xl:text-2xl">
                    {{ __('Choose a tariff plan according to your company request. For all questions, please contact support') }}
                </div>
            </div>

            <svg viewBox="0 0 1208 1024" class="absolute -translate-x-1/2 left-1/2 top-1/2 h-[60rem] -z-10"
                style="mask-image: radial-gradient(closest-side, white, transparent)">
                <ellipse cx="604" cy="512" rx="604" ry="512"
                    fill="url(#6d1bd035-0dd1-437e-93fa-59d316231eb0)"></ellipse>
                <defs>
                    <radialGradient id="6d1bd035-0dd1-437e-93fa-59d316231eb0">
                        <stop stop-color="#6366f1"></stop>
                        <stop offset="1" stop-color="#E935C1"></stop>
                    </radialGradient>
                </defs>
            </svg>
        </div>
    </div>

    <div class="bg-gray-100 relative z-20">
        <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8 pt-8 pb-16 relative">
            <div
                class="-mt-72 mx-auto w-full max-w-md shadow-lg bg-white border border-gray-200 rounded-3xl px-8 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-18 space-y-4 sm:space-y-8">
                <div class="text-gray-900 font-semibold text-lg md:text-2xl">{{ $tariff->name }}</div>
                <div class="text-gray-500 text-sm md:text-base">{{ __($tariff->description) }}</div>
                <div class="h-9 flex items-end text-gray-500 md:text-lg"><span
                        class="text-gray-900 font-bold text-2xl sm:text-3xl lg:text-4xl">{{ $tariff->price }}</span>
                    /{{ __('month') }}</div>
                <div class="space-y-2 sm:space-y-3">
                    <div class="flex items-center">
                        <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <div class="text-sm text-gray-500"><span
                                class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariff->max_ads }}</span>
                            {{ __('of ads') }}</div>
                    </div>
                    <div class="flex items-center">
                        <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <div class="text-sm text-gray-500"><span
                                class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariff->max_offices }}</span>
                            {{ __('of offices') }}</div>
                    </div>
                    <div class="flex items-center">
                        <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                        </svg>
                        <div class="text-sm text-gray-500"><span
                                class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariff->max_contacts }}</span>
                            {{ __('of contacts') }}</div>
                    </div>
                    @if ($tariff->can_have_hosting)
                        <div class="flex items-center">
                            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <div class="text-sm text-gray-500">{{ __('Hosting adding') }}</div>
                        </div>
                    @endif
                    @if ($tariff->can_create_guide)
                        <div class="flex items-center">
                            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <div class="text-sm text-gray-500">{{ __('Guide creating') }}</div>
                        </div>
                    @endif
                    @if ($tariff->priority_moderation)
                        <div class="flex items-center">
                            <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500"
                                aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                            </svg>
                            <div class="text-sm text-gray-500">{{ __('Priority moderation') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 pt-8 pb-16">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-3xl p-4 sm:p-8 md:p-12">
            <div class="text-center text-gray-900 font-semibold text-lg md:text-xl lg:text-2xl mb-6 lg:mb-10">{{ __('Pay the tariff') }}</div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                <div class="w-full cursor-pointer px-4 py-6 md:py-8 rounded-lg border border-gray-200 shadow-md hover:shadow-lg bg-white flex items-center justify-center group">
                    <svg class="w-8 h-8 text-gray-600 group-hover:text-gray-900 dark:text-white" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M4 5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H4Zm0 6h16v6H4v-6Z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd" d="M5 14a1 1 0 0 1 1-1h2a1 1 0 1 1 0 2H6a1 1 0 0 1-1-1Zm5 0a1 1 0 0 1 1-1h5a1 1 0 1 1 0 2h-5a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                      </svg>

                    <div class="ml-4 text-lg md:text-xl text-gray-600 group-hover:text-gray-900 font-semibold">{{ __('Card') }}</div>
                </div>

                <div class="w-full cursor-pointer px-4 py-6 md:py-8 rounded-lg border border-gray-200 shadow-md hover:shadow-lg bg-white flex items-center justify-center group">
                    <svg class="w-8 h-8 text-gray-600 group-hover:text-gray-900 dark:text-white" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 4h6v6H4V4Zm10 10h6v6h-6v-6Zm0-10h6v6h-6V4Zm-4 10h.01v.01H10V14Zm0 4h.01v.01H10V18Zm-3 2h.01v.01H7V20Zm0-4h.01v.01H7V16Zm-3 2h.01v.01H4V18Zm0-4h.01v.01H4V14Z"/>
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M7 7h.01v.01H7V7Zm10 10h.01v.01H17V17Z"/>
                      </svg>                      

                    <div class="ml-4 text-lg md:text-xl text-gray-600 group-hover:text-gray-900 font-semibold">{{ __('QR-code') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
