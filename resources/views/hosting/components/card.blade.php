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
                <div class="text-slate-800 dark:text-slate-200 text-xxs sm:text-xs font-bold">
                    {{ __('from') }} <span class="text-lg sm:text-xl lg:text-2xl">{{ collect($hosting->tariffs)->min('t') }}</span> ₽/{{ __('kW') }}
                </div>

                <div class="text-xxs xs:text-xs text-indigo-500 mt-1 sm:mt-2">{{ $hosting->city ?? 'Unknown' }}</div>

                <div class="relative flex mt-1 sm:mt-2 items-center">
                    <a class="block w-full" draggable="false"
                        href="{{ route('company.hosting', ['user' => $hosting->user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en'] ?? 'unknown-city') . '-' . $hosting->id]) }}">
                        <x-buttons.secondary-button class="w-full justify-center">{{ __('Details') }}</x-buttons.secondary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4">
        <div class="h-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-3 sm:gap-6">
            <div class="lg:col-span-4 sm:border-r border-slate-300 dark:border-slate-700 sm:pr-6">
                @if (count($hosting->images))
                    <div class="w-full aspect-4/3 overflow-hidden rounded-xl justify-center items-center">
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

                <div class="hidden md:block mt-6">
                    <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
                </div>
            </div>

            <div class="lg:col-span-3 flex flex-col justify-between">
                <div class="space-y-4">
                    <div>
                        <h2 class="sr-only">{{ __('Mining hotel') }} {{ $hosting->user->name }}</h2>

                        <a href="{{ route('company', ['user' => $hosting->user->slug]) }}" draggable="false"
                            class="block hover:underline text-sm xs:text-base sm:text-lg text-indigo-500 hover:text-indigo-600">{{ $hosting->user->name }}</a>

                        <x-tf :tf="$hosting->user->tf" :company="$hosting->user->name" class="mt-1 md:mt-2" />
                    </div>

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

                    <div class="md:hidden mb-4">
                        <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm text-slate-800 dark:text-slate-200 mb-2">{{ __('Conditions') }}</h3>

                        <ul role="list" class="list-disc space-y-1 pl-4 text-sm">
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

                        <ul role="list" class="list-disc space-y-1 pl-4 text-sm">
                            @if (!count($hosting->expenses))
                                <li class="text-slate-600 dark:text-slate-400">{{ __('Not specified') }}</li>
                            @else
                                @foreach ($hosting->expenses as $expense)
                                    <li class="text-slate-600 dark:text-slate-400">{{ $expense }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div>
                        <div class="text-xxs xs:text-xs text-indigo-500">{{ $hosting->city ?? 'Unknown' }}</div>

                        <div class="flex items-center gap-4 mt-1 sm:mt-2">
                            <a class="block w-full"
                                href="{{ route('company.hosting', ['user' => $hosting->user->slug, 'hosting' => strtolower($hosting->cityRelation->name['en'] ?? 'unknown-city') . '-' . $hosting->id]) }}">
                                <x-buttons.primary-button class="w-full">{{ __('Details') }}</x-buttons.primary-button>
                            </a>

                            @if ($auth?->id == $hosting->user->id && request()->routeIs('company.hostings'))
                                <a class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200"
                                    href="{{ route('hosting.edit', ['hosting' => $hosting->id]) }}" aria-label="{{ __('Edit') }}">
                                    <svg class="w-7 h-7" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
