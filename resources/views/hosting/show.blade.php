<x-app-layout title="Майнинг отель: разместить оборудование у компании {{ $hosting->user->name }}">
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-link :href="route('company', ['user' => $hosting->user->url_name])"></x-back-link>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ml-3">
                {{ __('Placement data') }}
            </h2>
        </div>
    </x-slot>

    @php
        $auth = Auth::user();
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @if (isset($moderation) && $auth && in_array($auth->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons')

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6 mb-6">
                <div class="mx-auto md:grid md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8 z-10">
                    <div
                        class="md:col-span-8{{ isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                        <x-carousel :images="isset($moderation->data['images']) ? $moderation->data['images'] : $hosting->images" min="128" max="128"></x-carousel>
                    </div>

                    <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-4 md:border-l md:border-gray-200 md:pl-8 space-y-5">
                        <h1
                            class="flex items-center text-sm font-bold tracking-tight text-gray-900 xs:text-base sm:text-lg{{ isset($moderation->data['address']) ? ' border border-indigo-500' : '' }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 mr-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ isset($moderation->data['address']) ? __($moderation->data['address']) : __($hosting->address) }}
                        </h1>

                        <p
                            class="text-lg sm:text-3xl tracking-tight text-gray-900{{ isset($moderation->data['price']) ? ' border border-indigo-500' : '' }}">
                            {{ isset($moderation->data['price']) ? $moderation->data['price'] : $hosting->price }} ₽</p>

                        <x-peculiarities
                            class="{{ isset($moderation->data['peculiarities']) ? ' border border-indigo-500' : '' }}"
                            :ps="isset($moderation->data['peculiarities'])
                                ? $moderation->data['peculiarities']
                                : $hosting->peculiarities" model="hosting"></x-peculiarities>

                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Conditions') }}</h3>

                            <ul role="list"
                                class="list-disc space-y-2 pl-4 text-sm{{ isset($moderation->data['conditions']) ? ' border border-indigo-500' : '' }}">
                                @php
                                    $c = isset($moderation->data['conditions'])
                                        ? $moderation->data['conditions']
                                        : $hosting->conditions;
                                @endphp

                                @if (!count($c))
                                    <li class="text-gray-400">{{ __('Not specified') }}</li>
                                @else
                                    @foreach ($c as $condition)
                                        <li class="text-gray-400">{{ $condition }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Additional costs') }}</h3>

                            <ul role="list"
                                class="list-disc space-y-2 pl-4 text-sm{{ isset($moderation->data['expenses']) ? ' border border-indigo-500' : '' }}">
                                @php
                                    $e = isset($moderation->data['expenses'])
                                        ? $moderation->data['expenses']
                                        : $hosting->expenses;
                                @endphp

                                @if (!count($e))
                                    <li class="text-gray-400">{{ __('Not specified') }}</li>
                                @else
                                    @foreach ($e as $expense)
                                        <li class="text-gray-400">{{ $expense }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 md:col-span-12">
                        @include('components.about-seller', ['user' => $hosting->user])

                        <div class="grid gap-2 sm:gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            @php
                                $contract = isset($moderation->data['contract'])
                                    ? $moderation->data['contract']
                                    : $hosting->contract;
                                $territory = isset($moderation->data['territory'])
                                    ? $moderation->data['territory']
                                    : $hosting->territory;
                                $energySupply = isset($moderation->data['energy_supply'])
                                    ? $moderation->data['energy_supply']
                                    : $hosting->energy_supply;
                            @endphp


                            <div class="{{ isset($moderation->data['contract']) ? 'border border-indigo-500' : '' }}">
                                <x-document :path="$contract" :name="__('Contract')"></x-document>
                            </div>

                            @if ($territory)
                                <div
                                    class="{{ isset($moderation->data['territory']) ? 'border border-indigo-500' : '' }}">
                                    <x-document :path="$territory" :name="__('Territory')"></x-document>
                                </div>
                            @endif

                            @if ($energySupply)
                                <div
                                    class="{{ isset($moderation->data['energy_supply']) ? 'border border-indigo-500' : '' }}">
                                    <x-document :path="$energySupply" :name="__('Energy supply agreement')"></x-document>
                                </div>
                            @endif
                        </div>

                        @php
                            $v = isset($moderation->data['video']) ? $moderation->data['video'] : $hosting->video;
                        @endphp

                        @if ($v)
                            <div
                                class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8{{ isset($moderation->data['video']) ? ' border border-indigo-500' : '' }}">
                                <iframe class="w-full h-full" src="{{ $v }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        @endif

                        <div>
                            <h3 class="font-bold tracking-tight text-gray-900 mt-8">{{ __('Description') }}</h3>

                            <div class="mt-5">
                                <p
                                    class="text-gray-700 text-sm whitespace-pre-line{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
                                    {{ isset($moderation->data['description']) ? $moderation->data['description'] : $hosting->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
            <div class="mx-auto md:grid md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8">
                <div class="md:col-span-8">
                    <x-carousel :images="$hosting->images" min="128" max="128"></x-carousel>
                </div>

                <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-4 md:border-l md:border-gray-200 md:pl-8 space-y-5">
                    <h1
                        class="flex items-center text-sm font-bold tracking-tight text-gray-900 xs:text-base sm:text-lg">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-500 mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ __($hosting->address) }}
                    </h1>

                    <p class="text-3xl tracking-tight text-gray-900">{{ $hosting->price }} ₽</p>

                    <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>

                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Conditions') }}</h3>

                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                            @if (!count($hosting->conditions))
                                <li class="text-gray-400">{{ __('Not specified') }}</li>
                            @else
                                @foreach ($hosting->conditions as $condition)
                                    <li class="text-gray-400">{{ $condition }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Additional costs') }}</h3>

                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                            @if (!count($hosting->expenses))
                                <li class="text-gray-400">{{ __('Not specified') }}</li>
                            @else
                                @foreach ($hosting->expenses as $expense)
                                    <li class="text-gray-400">{{ $expense }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div>
                        @if ($auth && $hosting->user->id == $auth->id)
                            <a class="block mt-6" href="{{ route('hosting.edit', ['hosting' => $hosting->id]) }}">
                                <x-primary-button>{{ __('Edit') }}</x-primary-button>
                            </a>
                        @else
                            <a class="block mt-6" href="{{ route('chat.start', ['user' => $hosting->user->id]) }}">
                                <x-primary-button>{{ __('Contact') }}</x-primary-button>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-8 md:col-span-12">
                    @include('components.about-seller', ['user' => $hosting->user])

                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                        <x-document :path="$hosting->contract" :name="__('Contract')"></x-document>

                        @if ($hosting->territory)
                            <x-document :path="$hosting->territory" :name="__('Territory')"></x-document>
                        @endif

                        @if ($hosting->energy_supply)
                            <x-document :path="$hosting->energy_supply" :name="__('Energy supply agreement')"></x-document>
                        @endif
                    </div>

                    @if ($hosting->user->id != $auth->id && count($hosting->contract_deficiencies))
                        <div x-data="{ deficiencies: [], done: false }">
                            <x-secondary-button
                                class="w-full sm:w-max justify-center bg-secondary-gradient text-white xs:py-3 mt-2 xs:mt-3 sm:mt-4"
                                @click="if (!status) {
                                    if ('{{ $auth && $auth->tariff }}') axios.get('{{ route('hosting.contract_deficiencies', ['hosting' => $hosting->id]) }}')
                                        .then(r => {
                                            if (r.data.success) {
                                                deficiencies = r.data.deficiencies;
                                                done = true;
                                                console.log(deficiencies);
                                            }
                                            else pushToastAlert(r.data.message, 'error');
                                        });
                                    else $dispatch('open-modal', 'need-subscription');
                                }">
                                <svg class="min-w-4 h-4 mr-2 xs:mr-3" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 4h3a1 1 0 0 1 1 1v15a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h3m0 3h6m-6 7 2 2 4-4m-5-9v4h4V3h-4Z" />
                                </svg>

                                <span>{{ __('Defects of the contract') }}</span>
                            </x-secondary-button>

                            <template x-if="done">
                                <div>
                                    <h5 class="text-xxs sm:text-xs mt-4 sm:mt-5 mb-1 text-gray-500 font-bold">
                                        {{ __('Anything that may result in the loss of equipment by the customer or other material or financial losses') }}
                                    </h5>

                                    <p x-show="!deficiencies[0].length"
                                        class="mt-1 text-xxs sm:text-xs text-gray-600 dark: text-gray-400">
                                        {{ __('No defects found') }}</p>
                                    <template x-for="problem in deficiencies[0]" :key="problem.problem">
                                        <p class="mt-1 flex-inline text-xxs sm:text-xs text-gray-600 dark: text-gray-400"
                                            x-text="problem.point + ' - ' + problem.problem"></p>
                                    </template>

                                    <h5 class="text-xxs sm:text-xs mt-3 sm:mt-4 mb-1 text-gray-500 font-bold">
                                        {{ __('Inaccuracies in the description of the terms of the contract that may lead to disputes') }}
                                    </h5>

                                    <p x-show="!deficiencies[1].length"
                                        class="mt-1 text-xxs sm:text-xs text-gray-600 dark: text-gray-400">
                                        {{ __('No defects found') }}</p>
                                    <template x-for="problem in deficiencies[1]" :key="problem.problem">
                                        <p class="mt-1 flex-inline text-xxs sm:text-xs text-gray-600 dark: text-gray-400"
                                            x-text="problem.point + ' - ' + problem.problem"></p>
                                    </template>

                                    <h5 class="text-xxs sm:text-xs mt-3 sm:mt-4 mb-1 text-gray-500 font-bold">
                                        {{ __('The presence of errors in the text or deviation from the standards for drafting contracts') }}
                                    </h5>

                                    <p x-show="!deficiencies[2].length"
                                        class="mt-1 text-xxs sm:text-xs text-gray-600 dark: text-gray-400">
                                        {{ __('No defects found') }}</p>
                                    <template x-for="problem in deficiencies[2]" :key="problem.problem">
                                        <p class="mt-1 flex-inline text-xxs sm:text-xs text-gray-600 dark: text-gray-400"
                                            x-text="problem.point + ' - ' + problem.problem"></p>
                                    </template>
                                </div>
                            </template>
                        </div>
                    @endif

                    @if ($hosting->video)
                        <div class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8">
                            <iframe class="w-full h-full" src="{{ $hosting->video }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    @endif

                    <div>
                        <h3 class="font-bold tracking-tight text-gray-900 mt-8">{{ __('Description') }}</h3>

                        <div class="mt-5">
                            <p class="text-gray-700 text-sm whitespace-pre-line">{{ $hosting->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
