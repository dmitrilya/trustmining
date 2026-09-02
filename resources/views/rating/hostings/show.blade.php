<x-app-layout :title='__("meta.rating.hostings.{$type}.title")' :description='__("meta.rating.hostings.{$type}.description")'>
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ __("meta.rating.hostings.{$type}.header") }}</h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-4 lg:p-6 space-y-2 sm:space-y-4">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" :href="route('ratings')" :name="__('meta.rating.breadcrumb')" />
            <x-breadcrumbs.breadcrumb position="2" :name='__("meta.rating.hostings.{$type}.breadcrumb")' />
        </x-breadcrumbs.breadcrumbs>

        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            <a href="{{ $type == 'best' ? '#' : route('rating.hostings.show', ['type' => 'best']) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ $type == 'best' ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('The best') }}
            </a>
            <a href="{{ $type == 'cheapest' ? '#' : route('rating.hostings.show', ['type' => 'cheapest']) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ $type == 'cheapest' ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('The cheapest') }}
            </a>
            <a href="{{ $type == 'reliable' ? '#' : route('rating.hostings.show', ['type' => 'reliable']) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ $type == 'reliable' ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('The most reliable') }}
            </a>
        </div>

        @foreach ($hostings as $hosting)
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-6">
                    <div class="lg:col-span-4 sm:border-r border-slate-300 dark:border-slate-700 sm:pr-6 space-y-5">
                        <h1 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl flex items-center gap-3">
                            <span
                                class="inline-flex mr-1 xs:mr-2 sm:mr-0 items-center justify-center min-w-8 h-8 rounded-xl bg-white/40 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400 font-mono text-base border border-slate-300 dark:border-slate-700">{{ $loop->iteration }}</span>
                            {{ $hosting->user->name }}
                        </h1>

                        <x-tf :tf="$hosting->user->tf" />

                        <h3 class="flex items-center text-sm font-bold tracking-tight text-slate-800 dark:text-slate-200 xs:text-base sm:text-lg">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ __($hosting->address) }}
                        </h3>

                        <div class="grid grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                            @foreach ($hosting->tariffs as $tariff)
                                <div class="rounded-xl py-2 sm:py-3 bg-indigo-50 dark:bg-indigo-900/50 border border-indigo-600 flex flex-col items-center">
                                    <div class="text-xl xs:text-2xl sm:text-3xl text-indigo-500 mb-1">{{ $tariff['t'] }} <span
                                            class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">₽/{{ __('kW') }}</span></div>
                                    <div class="text-xxs xs:text-xs tracking-wider text-slate-600 dark:text-slate-400 uppercase">{{ __('Uptime') }}
                                        {{ $tariff['u'] }}%</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="md:hidden">
                            <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
                        </div>

                        <div>
                            <h3 class="text-sm text-slate-800 dark:text-slate-200 mb-2">{{ __('Conditions') }}</h3>

                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                @if (!count($hosting->conditions))
                                    <li class="text-slate-600 dark:text-slate-400">{{ __('Not specified') }}</li>
                                @else
                                    @foreach ($hosting->conditions as $condition)
                                        <li class="text-slate-600 dark:text-slate-400">{{ $condition }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm text-slate-800 dark:text-slate-200 mb-2">{{ __('Additional costs') }}</h3>

                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                @if (!count($hosting->expenses))
                                    <li class="text-slate-600 dark:text-slate-400">{{ __('Not specified') }}</li>
                                @else
                                    @foreach ($hosting->expenses as $expense)
                                        <li class="text-slate-600 dark:text-slate-400">{{ $expense }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="lg:col-span-3 flex flex-col justify-between">
                        <div>
                            <x-carousel :images="$hosting->images" min="128" max="128"></x-carousel>

                            <div class="hidden md:block mt-6">
                                <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <a class="block" href="{{ route('company.hosting', ['user' => $hosting->user->slug]) }}">
                                <x-buttons.secondary-button>{{ __('Details') }}</x-buttons.primary-button>
                            </a>

                            <a class="block ml-2 sm:ml-3" href="{{ route('chat.start', ['user' => $hosting->user->id]) }}">
                                <x-buttons.primary-button>{{ __('Contact') }}</x-buttons.primary-button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
