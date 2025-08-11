<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-link :href="route('company', ['user' => $company->user->url_name])"></x-back-link>

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight ml-3">
                {{ $company->name }}
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
                    @if ((isset($moderation->data['images']) && count($moderation->data['images'])) || count($company->images))
                        <div
                            class="mb-4 sm:mb-8 md:mb-0 md:col-span-8 md:border-r md:border-gray-200 md:pr-8{{ isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                            <x-carousel :images="isset($moderation->data['images'])
                                ? $moderation->data['images']
                                : $company->images" min="128" max="128"></x-carousel>
                        </div>
                    @endif

                    <div class="md:col-span-4 space-y-5">
                        <div class="{{ isset($moderation->data['logo']) ? 'border border-indigo-500' : '' }}">
                            @include('components.about-seller', ['user' => $company->user])
                        </div>

                        @if (isset($moderation->data['bg_logo']))
                            <div class="border border-indigo-500">
                                <img class="h-40" src="{{ Storage::url($moderation->data['bg_logo']) }}"
                                    alt="">
                            </div>
                        @endif

                        @if ($company->card['type'] == 'LEGAL')
                            <h1
                                class="flex items-center text-sm sm:text-base font-bold tracking-tight text-gray-900">
                                <svg class="w-5 h-5 text-gray-500 mr-2" aria-hidden="true" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $company->card['address']['unrestricted_value'] }}
                            </h1>
                        @endif

                        @if ($company->site && $company->user->tariff && $company->user->tariff->can_link_site)
                            <a href="{{ $company->site }}" target="_blank"
                                class="text-indigo-500 hover:text-indigo-700 flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M4.37 7.657c2.063.528 2.396 2.806 3.202 3.87 1.07 1.413 2.075 1.228 3.192 2.644 1.805 2.289 1.312 5.705 1.312 6.705M20 15h-1a4 4 0 0 0-4 4v1M8.587 3.992c0 .822.112 1.886 1.515 2.58 1.402.693 2.918.351 2.918 2.334 0 .276 0 2.008 1.972 2.008 2.026.031 2.026-1.678 2.026-2.008 0-.65.527-.9 1.177-.9H20M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ __('Company site') }}
                            </a>
                        @endif

                        <div class="my-5">
                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                @php
                                    $statuses = [
                                        'ACTIVE' => 'Действующая',
                                        'LIQUIDATING' => 'Ликвидируется',
                                        'LIQUIDATED' => 'Ликвидирована',
                                        'BANKRUPT' => 'Банкротство',
                                        'REORGANIZING' =>
                                            'В процессе присоединения к другому юрлицу, с последующей ликвидацией',
                                    ];
                                @endphp

                                <li class="text-gray-400">{{ __('Status') . ': ' }}<span
                                        class="text-gray-600">{{ $statuses[$company->card['state']['status']] }}</span>
                                </li>
                                <li class="text-gray-400">{{ __('TIN') . ': ' }}<span
                                        class="text-gray-600">{{ $company->card['inn'] }}</span>
                                </li>
                                <li class="text-gray-400">{{ __('OGRN') . ': ' }}<span
                                        class="text-gray-600">{{ $company->card['ogrn'] }}</span>
                                </li>
                                @if (array_key_exists('kpp', $company->card))
                                <li class="text-gray-400">{{ __('KPP') . ': ' }}<span
                                        class="text-gray-600">{{ $company->card['kpp'] }}</span>
                                </li>
                                @endif
                                <li class="text-gray-400">{{ __('Registration date') . ': ' }}<span
                                        class="date-transform text-gray-600" data-type="date"
                                        data-date="{{ $company->card['state']['registration_date'] }}"></span>
                                </li>
                                <li class="text-gray-400">{{ __('Employee count') . ': ' }}<span
                                        class="text-gray-600">{{ $company->card['employee_count'] ? $company->card['employee_count'] : 0 }}</span>
                                </li>

                                @if ($company->card['type'] == 'LEGAL')
                                    <li class="text-gray-400">{{ __('Authorized capital') . ': ' }}<span
                                            class="text-gray-600">{{ $company->card['capital'] }} ₽</span>
                                    </li>

                                    <div class="text-sm md:text-lg text-gray-800 font-semibold mt-3">
                                        {{ __('Founders') }}</div>

                                    @foreach ($company->card['founders'] as $founder)
                                        <div class="ml-4">
                                            <li class="text-gray-400">{{ __('Name') . ': ' }}<span
                                                    class="text-gray-600">{{ $founder['name'] }}
                                                    ({{ $founder['share'] }}%)
                                                </span>
                                            </li>
                                            <li class="text-gray-400 mt-1">{{ __('TIN') . ': ' }}<span
                                                    class="text-gray-600">{{ $founder['inn'] }}</span>
                                            </li>
                                        </div>
                                    @endforeach
                                @endif

                                @if (array_key_exists('managers', $company->card))
                                    <div class="text-sm md:text-lg text-gray-800 font-semibold mt-3">
                                        {{ __('Managers') }}
                                    </div>
    
                                    @foreach ($company->card['managers'] as $manager)
                                        <div class="ml-4">
                                            <li class="text-gray-400">{{ __('Name') . ': ' }}<span
                                                    class="text-gray-600">{{ $manager['name'] }}</span>
                                            </li>
                                            <li class="text-gray-400 mt-1">{{ __('TIN') . ': ' }}<span
                                                    class="text-gray-600">{{ $manager['inn'] }}</span>
                                            </li>
                                        </div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="mt-8 md:col-span-12">
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            @foreach ($company->documents as $document)
                                <x-document :path="$document['path']" :name="$document['name']"></x-document>
                            @endforeach
                        </div>

                        @php
                            $v = isset($moderation->data['video']) ? $moderation->data['video'] : $company->video;
                            $d = isset($moderation->data['description'])
                                ? $moderation->data['description']
                                : $company->description;
                        @endphp

                        @if ($v)
                            <div
                                class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8{{ isset($moderation->data['video']) ? ' border border-indigo-500' : '' }}">
                                <iframe class="w-full h-full" src="{{ $v }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                            </div>
                        @endif

                        @if ($d)
                            <div>
                                <h3 class="font-bold tracking-tight text-gray-900 mt-8">{{ __('Description') }}</h3>

                                <div class="mt-5">
                                    <p
                                        class="text-gray-700 text-sm whitespace-pre-line{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
                                        {{ $d }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
            <div class="mx-auto md:grid md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8">
                @if (count($company->images))
                    <div class="mb-4 sm:mb-8 md:mb-0 md:col-span-8 md:border-r md:border-gray-200 md:pr-8">
                        <x-carousel :images="$company->images" min="128" max="128"></x-carousel>
                    </div>
                @endif

                <div class="md:col-span-4 space-y-5">
                    <div>
                        @include('components.about-seller', ['user' => $company->user])
                    </div>

                    @if ($company->card['type'] == 'LEGAL')
                        <h1
                            class="flex items-center text-sm sm:text-base font-bold tracking-tight text-gray-900">
                            <svg class="w-5 h-5 text-gray-500 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $company->card['address']['unrestricted_value'] }}
                        </h1>
                    @endif

                    <div class="my-5">
                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                            @php
                                $statuses = [
                                    'ACTIVE' => 'Действующая',
                                    'LIQUIDATING' => 'Ликвидируется',
                                    'LIQUIDATED' => 'Ликвидирована',
                                    'BANKRUPT' => 'Банкротство',
                                    'REORGANIZING' =>
                                        'В процессе присоединения к другому юрлицу, с последующей ликвидацией',
                                ];
                            @endphp

                            <li class="text-gray-400">{{ __('Status') . ': ' }}<span
                                    class="text-gray-600">{{ $statuses[$company->card['state']['status']] }}</span>
                            </li>
                            <li class="text-gray-400">{{ __('TIN') . ': ' }}<span
                                    class="text-gray-600">{{ $company->card['inn'] }}</span>
                            </li>
                            <li class="text-gray-400">{{ __('OGRN') . ': ' }}<span
                                    class="text-gray-600">{{ $company->card['ogrn'] }}</span>
                            </li>
                            @if (array_key_exists('kpp', $company->card))
                            <li class="text-gray-400">{{ __('KPP') . ': ' }}<span
                                    class="text-gray-600">{{ $company->card['kpp'] }}</span>
                            </li>
                            @endif
                            <li class="text-gray-400">{{ __('Registration date') . ': ' }}<span
                                    class="date-transform text-gray-600" data-type="date"
                                    data-date="{{ $company->card['state']['registration_date'] }}"></span>
                            </li>
                            <li class="text-gray-400">{{ __('Employee count') . ': ' }}<span
                                    class="text-gray-600">{{ $company->card['employee_count'] ? $company->card['employee_count'] : 0 }}</span>
                            </li>

                            @if ($company->card['type'] == 'LEGAL')
                                <li class="text-gray-400">{{ __('Authorized capital') . ': ' }}<span
                                        class="text-gray-600">{{ $company->card['capital'] }} ₽</span>
                                </li>

                                <div class="text-sm md:text-lg text-gray-800 font-semibold mt-3">{{ __('Founders') }}
                                </div>

                                @foreach ($company->card['founders'] as $founder)
                                    <div class="ml-4">
                                        <li class="text-gray-400">{{ __('Name') . ': ' }}<span
                                                class="text-gray-600">{{ $founder['name'] }}
                                                ({{ $founder['share'] }}%)
                                            </span>
                                        </li>
                                        <li class="text-gray-400 mt-1">{{ __('TIN') . ': ' }}<span
                                                class="text-gray-600">{{ $founder['inn'] }}</span>
                                        </li>
                                    </div>
                                @endforeach
                            @endif

                            @if (array_key_exists('managers', $company->card))
                                <div class="text-sm md:text-lg text-gray-800 font-semibold mt-3">{{ __('Managers') }}
                                </div>
    
                                @foreach ($company->card['managers'] as $manager)
                                    <div class="ml-4">
                                        <li class="text-gray-400">{{ __('Name') . ': ' }}<span
                                                class="text-gray-600">{{ $manager['name'] }}</span>
                                        </li>
                                        <li class="text-gray-400 mt-1">{{ __('TIN') . ': ' }}<span
                                                class="text-gray-600">{{ $manager['inn'] }}</span>
                                        </li>
                                    </div>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div>
                        @if ($auth && $company->user->id == $auth->id)
                            <a class="block mt-6" href="{{ route('company.edit', ['company' => $company->id]) }}">
                                <x-primary-button>{{ __('Edit') }}</x-primary-button>
                            </a>
                        @else
                            <a class="block mt-6" href="{{ route('chat.start', ['user' => $company->user->id]) }}">
                                <x-primary-button>{{ __('Contact') }}</x-primary-button>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-8 md:col-span-12">
                    @if (count($company->documents))
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            @foreach ($company->documents as $document)
                                <x-document :path="$document['path']" :name="$document['name']"></x-document>
                            @endforeach
                        </div>
                    @endif

                    @if ($company->video)
                        <div class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8">
                            <iframe class="w-full h-full" src="{{ $company->video }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    @endif

                    @if ($company->description)
                        <div>
                            <h3 class="font-bold tracking-tight text-gray-900 mt-8">{{ __('Description') }}</h3>

                            <div class="mt-5">
                                <p class="text-gray-700 text-sm whitespace-pre-line">{{ $company->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
