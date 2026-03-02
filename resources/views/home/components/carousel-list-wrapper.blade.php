@include('home.components.carousel-list')

<div draggable="false"
    class="shrink-0 snap-start mr-2 sm:mr-4 w-[calc(100%-1.4rem)] xs:w-[calc(50%-1rem)] sm:w-[calc(50%-1.6rem)] md:w-[calc(33.333%-1.5rem)] {{ !isset($bigWrapper) ? 'lg:w-[calc(50%-1.7rem)] xl:w-[calc(33.333%-1.5rem)]' : 'xl:w-[calc(25%-1.5rem)]' }}">
    <div
        class="card relative sm:max-w-md h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden rounded-xl flex flex-col offer-card">
        @switch($model)
            @case('ad')
                <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
                    <a class="block w-full" href="{{ route('ads', ['adCategory' => 'miners']) }}">
                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="/img/miners_xs.jpg">

                            <img class="w-full object-cover" src="/img/miners_sm.jpg" alt="Ad preview">
                        </picture>
                    </a>
                </div>

                <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
                    <div>
                        <p class="text-xs xs:text-sm md:text-base text-slate-950 dark:text-slate-50 font-bold">
                            {{ __('Full catalog of miners') }}
                        </p>

                        <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                            {{ __('Find the deal from trusted sellers only') }}
                        </p>
                    </div>

                    <div class="mt-2 md:mt-3">
                        <a class="block w-full" href="{{ route('ads', ['adCategory' => 'miners']) }}">
                            <x-primary-button
                                class="w-full justify-center text-xxs xs:text-xs">{{ __('Open') }}</x-primary-button>
                        </a>
                    </div>
                </div>
            @break

            @case('hosting')
                <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
                    <a class="block w-full" href="{{ route('hostings') }}">
                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="/img/hostings_xs.jpg">

                            <img class="w-full object-cover" src="/img/hostings_sm.jpg" alt="Hosting preview">
                        </picture>
                    </a>
                </div>
                <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
                    <div>
                        <p class="text-xs xs:text-sm md:text-base text-slate-950 dark:text-slate-50 font-bold">
                            {{ __('Full list of hostings') }}
                        </p>

                        <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-slate-600 dark:text-slate-400">
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
            @break

            @case('article')
                <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
                    <a class="block w-full" href="{{ route('insight.index') }}">
                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="/img/articles_xs.jpg">

                            <img class="w-full object-cover" src="/img/articles_sm.jpg" alt="Article preview">
                        </picture>
                    </a>
                </div>

                <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
                    <div>
                        <p
                            class="text-xs xs:text-sm md:text-base text-slate-950 dark:text-slate-50 font-bold">
                            {{ __('Media platform') }}<br>TM Insight
                        </p>

                        <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                            {{ __('Expert articles, market analysis, trading and corporate channels') }}
                        </p>
                    </div>

                    <div class="mt-2 md:mt-3">
                        <a class="block w-full" href="{{ route('insight.index') }}">
                            <x-primary-button
                                class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
                        </a>
                    </div>
                </div>
            @break

            @case('gpu')
                <div class="w-full aspect-[4/3] overflow-hidden rounded-xl flex justify-center items-center">
                    <a class="block w-full" href="{{ route('ads', ['adCategory' => 'gpus']) }}">
                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="/img/gpu_xs.jpg">

                            <img class="w-full object-cover" src="/img/gpu_sm.jpg" alt="Article preview">
                        </picture>
                    </a>
                </div>

                <div class="flex flex-col flex-grow justify-between p-2 sm:p-3">
                    <div>
                        <p
                            class="text-xs xs:text-sm md:text-base text-slate-950 dark:text-slate-50 font-bold">
                            {{ __('Full catalog of GPU') }}
                        </p>

                        <p class="mt-2 md:mt-3 text-xxs xs:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                            {{ __('Gas gensets in stock and on order') }}
                        </p>
                    </div>

                    <div class="mt-2 md:mt-3">
                        <a class="block w-full" href="{{ route('ads', ['adCategory' => 'gpus']) }}">
                            <x-primary-button
                                class="w-full justify-center text-xxs xs:text-xs">{{ __('Open') }}</x-primary-button>
                        </a>
                    </div>
                </div>
            @break
        @endswitch
    </div>
</div>
