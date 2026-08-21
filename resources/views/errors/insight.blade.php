<x-insight-layout noindex="true" :title='__("errors.insight.$code.title")'>
    <div
        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="min-w-6 w-6 h-6 sm:min-w-8 sm:w-8 sm:h-8 mr-2 sm:mr-3 rounded-full border border-indigo-500 p-[0.07rem]">
                    <img src="/img/apple-touch-icon.png" alt="logo" class="w-full rounded-full">
                </div>

                <div>
                    <p class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 font-bold">
                        Trust Mining Developers
                    </p>

                    <div class="flex items-center">
                        <svg class="w-3.5 h-3.5 text-slate-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="1.5"
                                d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z" />
                        </svg>

                        <div class="ml-1 sm:ml-2 text-xxs sm:text-xs text-slate-500">{{ $code }}</div>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="font-bold text-lg lg:text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ __("errors.insight.$code.title") }}</h1>

        <div class="w-full overflow-hidden rounded-xl">
            <img fetchpriority="high" class="w-full" src="/img/errors/{{ $code }}.webp" alt="error {{ $code }}" />
        </div>

        <div>
            <h2 itemprop="description" class="mb-2 sm:mb-3 text-xs sm:text-sm text-slate-500">{{ __("errors.insight.$code.headline") }}</h2>

            <div class="space-x-2 inline">
                <span>#{{ __('We\'re sorry') }}</span>
                <span>#{{ __('Understand and forgive') }}</span>
                <span>#{{ __('Mistakes happen') }}</span>
            </div>

            <div class="mt-6 sm:mt-8 lg:mt-10 text-xs xs:text-sm sm:text-base space-y-2 sm:space-y-4">
                @if (Lang::has("errors.insight.$code.paragraphs"))
                    @foreach (trans("errors.insight.$code.paragraphs") as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                @else
                    <p>{{ __('An unexpected error occurred.') }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div>
                @if (isset($published_at))
                    <p class="text-xxs sm:text-xs text-slate-500">{{ $published_at->diffForHumans() }}</p>
                @endif
            </div>

            <div class="ml-auto flex items-center">
                <div class="flex items-center">
                    <svg aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24"
                        class="w-5 h-5 sm:w-6 sm:h-6 lg:w-7 lg:h-7 text-slate-800 dark:text-slate-200">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 11c.889-.086 1.416-.543 2.156-1.057a22.323 22.323 0 0 0 3.958-5.084 1.6 1.6 0 0 1 .582-.628 1.549 1.549 0 0 1 1.466-.087c.205.095.388.233.537.406a1.64 1.64 0 0 1 .384 1.279l-1.388 4.114M7 11H4v6.5A1.5 1.5 0 0 0 5.5 19v0A1.5 1.5 0 0 0 7 17.5V11Zm6.5-1h4.915c.286 0 .372.014.626.15.254.135.472.332.637.572a1.874 1.874 0 0 1 .215 1.673l-2.098 6.4C17.538 19.52 17.368 20 16.12 20c-2.303 0-4.79-.943-6.67-1.475" />
                    </svg>

                    <p class="text-xxs sm:text-xs text-slate-500 ml-1.5">{{ $code }}</p>
                </div>
                <div class="flex items-center ml-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-800 dark:text-slate-200" aria-hidden="true" width="24" height="24" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M4.998 7.78C6.729 6.345 9.198 5 12 5c2.802 0 5.27 1.345 7.002 2.78a12.713 12.713 0 0 1 2.096 2.183c.253.344.465.682.618.997.14.286.284.658.284 1.04s-.145.754-.284 1.04a6.6 6.6 0 0 1-.618.997 12.712 12.712 0 0 1-2.096 2.183C17.271 17.655 14.802 19 12 19c-2.802 0-5.27-1.345-7.002-2.78a12.712 12.712 0 0 1-2.096-2.183 6.6 6.6 0 0 1-.618-.997C2.144 12.754 2 12.382 2 12s.145-.754.284-1.04c.153-.315.365-.653.618-.997A12.714 12.714 0 0 1 4.998 7.78ZM12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"
                            clip-rule="evenodd" />
                    </svg>

                    <p itemprop="userInteractionCount" class="text-xxs sm:text-xs text-slate-500 ml-1.5">{{ $code }}</p>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="leftSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
