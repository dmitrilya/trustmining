@include('home.components.carousel-list')

@switch($model)
    @case('ad')
        <div draggable="false"
            class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]">
            <div
                class="card relative sm:max-w-md p-2 h-full md:p-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-lg flex flex-col justify-between offer-card">
                <div>
                    <div class="w-full aspect-[1/1] overflow-hidden rounded-lg flex justify-center items-center">
                        <a class="block w-full" href="{{ route('ads', ['adCategory' => 'miners']) }}">
                            <picture class="w-full">
                                <source media="(max-width: 430px)" srcset="/img/ads_xs.jpg">

                                <img class="w-full object-cover" src="/img/ads_sm.jpg" alt="Ad preview">
                            </picture>
                        </a>
                    </div>

                    <p class="mt-2 md:mt-3 text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                        {{ __('Full catalog of miners') }}
                    </p>

                    <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Find the best deal from trusted sellers only') }}
                    </p>
                </div>

                <div class="mt-2 md:mt-3">
                    <a class="block w-full" href="{{ route('ads', ['adCategory' => 'miners']) }}">
                        <x-primary-button
                            class="w-full justify-center text-xxs xs:text-xs">{{ __('Open') }}</x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    @break

    @case('hosting')
        <div draggable="false"
            class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]">
            <div
                class="card relative sm:max-w-md p-2 h-full md:p-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-lg flex flex-col justify-between offer-card">
                <div>
                    <div class="w-full aspect-[1/1] overflow-hidden rounded-lg flex justify-center items-center">
                        <a class="block w-full" href="{{ route('hostings') }}">
                            <picture class="w-full">
                                <source media="(max-width: 430px)" srcset="/img/hostings_xs.jpg">

                                <img class="w-full object-cover" src="/img/hostings_sm.jpg" alt="Hosting preview">
                            </picture>
                        </a>
                    </div>

                    <p class="mt-2 md:mt-3 text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                        {{ __('Full list of hostings') }}
                    </p>

                    <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Find the most reliable hosting with the best plan') }}
                    </p>
                </div>

                <div class="mt-2 md:mt-3">
                    <a class="block w-full" href="{{ route('hostings') }}">
                        <x-primary-button
                            class="w-full justify-center text-xxs xs:text-xs">{{ __('Open') }}</x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    @break

    @case('article')
        <div draggable="false"
            class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]">
            <div
                class="card relative sm:max-w-md h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden rounded-lg flex flex-col justify-between offer-card">
                <div>
                    <div class="w-full aspect-[1/1] overflow-hidden rounded-lg flex justify-center items-center">
                        <a class="block w-full" href="{{ route('insight.index') }}">
                            <picture class="w-full">
                                <source media="(max-width: 430px)" srcset="/img/articles_xs.jpg">

                                <img class="w-full object-cover" src="/img/articles_sm.jpg" alt="Article preview">
                            </picture>
                        </a>
                    </div>

                    <p class="px-2 md:px-3 mt-2 md:mt-3 text-xs xs:text-sm md:text-base text-gray-950 dark:text-gray-50 font-bold">
                        {{ __('Media platform') }}<br>TM Insight
                    </p>

                    <p class="px-2 md:px-3 mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Expert articles, market analysis, trading and corporate channels') }}
                    </p>
                </div>

                <div class="p-2 md:p-3">
                    <a class="block w-full" href="{{ route('insight.index') }}">
                        <x-primary-button
                            class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    @break
@endswitch
