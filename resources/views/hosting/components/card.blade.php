@if ($sm ?? false)
    <div class="card sm:max-w-md h-full bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden rounded-xl flex flex-col">
        @if (count($hosting->images))
            <div class="w-full aspect-4/3 overflow-hidden rounded-xl justify-center items-center">
                <a class="block w-full" href="{{ route('company.hostings', ['user' => $hosting->user->slug]) }}" draggable="false" x-data="{ shown: false }"
                    x-intersect.once.margin.300px="shown = true" aria-label="{{ $hosting->user->name }} hosting">
                    @php
                        $preview = explode('.', $hosting->images[0]);
                        $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                        $previewxs = $baseName . '_224' . '.' . $preview[1];
                        $previewsm = $baseName . '_400' . '.' . $preview[1];
                    @endphp

                    <template x-if="shown">
                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                            <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Hosting preview">
                        </picture>
                    </template>
                </a>
            </div>
        @endif

        <div class="flex flex-col grow justify-between p-2 sm:p-3">
            <div>
                <a href="{{ route('company', ['user' => $hosting->user->slug]) }}" draggable="false"
                    class="block hover:underline text-xs sm:text-sm text-indigo-500 hover:text-indigo-600">{{ $hosting->user->name }}</a>

                <x-tf :tf="$hosting->user->tf" :company="$hosting->user->name" class="my-1 md:my-2" />

                <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
            </div>

            <div class="mt-2 sm:mt-3">
                <div class="text-slate-800 dark:text-slate-200 text-sm sm:text-base md:text-lg lg:text-xl font-bold">
                    {{ collect($hosting->tariffs)->min('t') }} <span class="text-xxs sm:text-xs">₽/{{ __('kW') }}</span>
                </div>

                <a href="{{ route('company.hosting', ['user' => $hosting->user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en']) . '-' . $hosting->id]) }}"
                    target="_blank" draggable="false"
                    class="block hover:underline text-xxs xs:text-xs text-indigo-500 hover:text-indigo-600 mt-1 sm:mt-2">{{ $hosting->city }}</a>

                <div class="relative flex mt-1 sm:mt-2 items-center">
                    <a class="block w-full" draggable="false"
                        href="{{ route('company.hosting', ['user' => $hosting->user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en']) . '-' . $hosting->id]) }}">
                        <x-buttons.secondary-button class="w-full justify-center">{{ __('Details') }}</x-buttons.secondary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4">
        <div class="h-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-6">
            <div class="lg:col-span-4 sm:border-r border-slate-300 dark:border-slate-700 sm:pr-6">
                @if (count($hosting->images))
                    <div class="w-full aspect-4/3 overflow-hidden rounded-xl justify-center items-center mb-6">
                        <a class="block w-full" href="{{ route('company.hostings', ['user' => $hosting->user->slug]) }}" draggable="false"
                            x-data="{ shown: false }" x-intersect.once.margin.300px="shown = true" aria-label="{{ $hosting->user->name }} hosting">
                            @php
                                $preview = explode('.', $hosting->images[0]);
                                $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                                $previewxs = $baseName . '_224' . '.' . $preview[1];
                                $previewsm = $baseName . '_400' . '.' . $preview[1];
                            @endphp

                            <template x-if="shown">
                                <picture class="w-full">
                                    <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                                    <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Hosting preview">
                                </picture>
                            </template>
                        </a>
                    </div>
                @endif

                <div class="hidden md:block">
                    <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
                </div>
            </div>

            <div class="lg:col-span-3 flex flex-col justify-between">
                <div class="space-y-5">
                    <h3 class="flex items-center text-xs xs:text-sm sm:text-base font-bold tracking-tight text-slate-800 dark:text-slate-200">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-600 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __($hosting->city) }}
                    </h3>

                    <div class="grid grid-cols-3 xl:grid-cols-2 gap-2">
                        @foreach ($hosting->tariffs as $tariff)
                            <div class="rounded-xl py-2 sm:py-3 bg-indigo-500/10 border border-indigo-600 flex flex-col items-center">
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
                </div>

                <div class="space-y-5">
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

                    <a class="block mt-6 w-full"
                        href="{{ route('company.hosting', ['user' => $hosting->user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en']) . '-' . $hosting->id]) }}">
                        <x-buttons.primary-button class="w-full">{{ __('Details') }}</x-buttons.primary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif
