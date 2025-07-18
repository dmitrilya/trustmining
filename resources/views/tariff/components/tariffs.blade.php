<div class="grid justify-items-center grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-8 -mt-72">
    <div
        class="w-full max-w-md shadow-lg bg-white border border-gray-200 rounded-3xl px-8 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-18 space-y-4 sm:space-y-8">
        <div class="text-gray-900 font-semibold text-lg md:text-2xl">{{ $tariffs[0]->name }}</div>
        <div class="text-gray-500 text-sm md:text-base">{{ __($tariffs[0]->description) }}</div>
        <div class="h-9 flex items-end text-gray-500 md:text-lg"><span
                class="text-gray-900 font-bold text-2xl sm:text-3xl lg:text-4xl">{{ $tariffs[0]->price * 30 }}</span>
            /{{ __('month') }}</div>
        <a
            href="{{ route('tariff', ['tariff' => $tariffs[0]->id]) }}"><x-primary-button>{{ __('Buy plan') }}</x-primary-button></a>
        <div class="space-y-2 sm:space-y-3">
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[0]->max_ads }}</span>
                    {{ __('of ads') }}</div>
            </div>
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[0]->max_offices }}</span>
                    {{ __('of offices') }}</div>
            </div>
            @if ($tariffs[0]->can_have_hosting)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Hosting adding') }}</div>
                </div>
            @endif
            @if ($tariffs[0]->can_have_phone)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Phone number') }}</div>
                </div>
            @endif
            @if ($tariffs[0]->can_create_guide)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Guide creating') }}</div>
                </div>
            @endif
            @if ($tariffs[0]->priority_moderation)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Priority moderation') }}</div>
                </div>
            @endif
        </div>
    </div>
    <div
        class="w-full max-w-md shadow-lg bg-white border border-gray-200 rounded-3xl px-8 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-18 space-y-4 sm:space-y-8">
        <div class="text-gray-900 font-semibold text-lg md:text-2xl">{{ $tariffs[1]->name }}</div>
        <div class="text-gray-500 text-sm md:text-base">{{ __($tariffs[1]->description) }}</div>
        <div class="h-9 flex items-end text-gray-500 md:text-lg"><span
                class="text-gray-900 font-bold text-2xl sm:text-3xl lg:text-4xl">{{ $tariffs[1]->price * 30 }}</span>
            /{{ __('month') }}</div>
        <a
            href="{{ route('tariff', ['tariff' => $tariffs[1]->id]) }}"><x-primary-button>{{ __('Buy plan') }}</x-primary-button></a>
        <div class="space-y-2 sm:space-y-3">
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[1]->max_ads }}</span>
                    {{ __('of ads') }}</div>
            </div>
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[1]->max_offices }}</span>
                    {{ __('of offices') }}</div>
            </div>
            @if ($tariffs[1]->can_have_hosting)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Hosting adding') }}</div>
                </div>
            @endif
            @if ($tariffs[1]->can_have_phone)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Phone number') }}</div>
                </div>
            @endif
            @if ($tariffs[1]->can_create_guide)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Guide creating') }}</div>
                </div>
            @endif
            @if ($tariffs[1]->priority_moderation)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Priority moderation') }}</div>
                </div>
            @endif
        </div>
    </div>
    <div
        class="w-full max-w-md shadow-lg bg-gray-900 border-2 border-indigo-500 rounded-3xl px-8 py-10 sm:px-10 sm:py-12 lg:px-14 lg:py-18 space-y-4 sm:space-y-8">
        <div class="text-white font-semibold text-lg md:text-2xl">{{ $tariffs[2]->name }}</div>
        <div class="text-gray-400 text-sm md:text-base">{{ __($tariffs[2]->description) }}</div>
        <div class="h-9 flex items-end text-white md:text-lg"><span
                class="font-bold text-2xl sm:text-3xl lg:text-4xl">{{ __('Custom') }}</span></div>
        <a
            href="{{ route('support', ['chat' => 1, 'message' => __('Good day! I would like to discuss the Enterprise tariff plan')]) }}"><x-primary-button>{{ __('Contact') }}</x-primary-button></a>
        <div class="space-y-2 sm:space-y-3">
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-400"><span
                        class="text-white font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[2]->max_ads }}</span>
                    {{ __('of ads') }}</div>
            </div>
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-400"><span
                        class="text-white font-semibold text-base sm:text-lg lg:text-xl">{{ $tariffs[2]->max_offices }}</span>
                    {{ __('of offices') }}</div>
            </div>
            @if ($tariffs[2]->can_have_hosting)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-400">{{ __('Hosting adding') }}</div>
                </div>
            @endif
            @if ($tariffs[2]->can_have_phone)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-500">{{ __('Phone number') }}</div>
                </div>
            @endif
            @if ($tariffs[2]->can_create_guide)
                <div class="flex items-center">
                    <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <div class="text-sm text-gray-400">{{ __('Guide creating') }}</div>
                </div>
            @endif
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-400">{{ __('The fastest moderation') }}</div>
            </div>
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-white" aria-hidden="true" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-400">{{ __('Advertising space on the website') }}</div>
            </div>
        </div>
    </div>
</div>

<div class="grid justify-items-center mt-4 lg:mt-8">
    <div
        class="w-full max-w-md lg:max-w-none bg-white border border-gray-200 rounded-3xl px-10 py-8 sm:px-12 sm:py-10 lg:px-18 lg:py-14 space-y-3 sm:space-y-5">
        <div class="text-gray-900 font-semibold text-lg md:text-2xl">Base</div>
        <div class="text-gray-500 text-xs sm:text-base md:text-lg">
            {{ __('Starter plan to test all the platform functionality. Adding third-party contacts and posting hosting information is not available') }}
        </div>
        <div class="space-y-2 sm:space-y-0 sm:flex sm:space-x-10">
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">2</span>
                    {{ __('of ads') }}</div>
            </div>
            <div class="flex items-center">
                <svg class="mr-4 flex-shrink-0 w-4 h-4 text-indigo-600 dark:text-indigo-500" aria-hidden="true"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                </svg>
                <div class="text-sm text-gray-500"><span
                        class="text-gray-900 font-semibold text-base sm:text-lg lg:text-xl">1</span>
                    {{ __('of offices') }}</div>
            </div>
        </div>
    </div>
</div>
