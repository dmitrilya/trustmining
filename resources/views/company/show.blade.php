<x-app-layout :title="__('meta.company.show.title', ['name' => $company->name])" :description="__('meta.company.show.description', ['name' => $company->name])">
    <script src="https://api-maps.yandex.ru/v3/?apikey=edbdf37c-6677-43bf-8434-455e393b7362&lang=ru_RU"></script>
    
    @php
        $auth = Auth::user();
        $user = $company->user;
        $card = $company->card;
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @include('shop.components.about')

        @if (isset($moderation))
            @include('moderation.components.buttons')

            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-10 mb-2 sm:mb-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                    @if ((isset($moderation->data['images']) && count($moderation->data['images'])) || count($company->images))
                        <div
                            class="sm:border-r border-slate-300 dark:border-slate-700 sm:pr-6{{ isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                            <x-carousel :images="isset($moderation->data['images']) ? $moderation->data['images'] : $company->images" min="128" max="128"></x-carousel>
                        </div>
                    @endif

                    <div class="space-y-5">
                        @if (isset($moderation->data['bg_logo']))
                            <div class="border border-indigo-500">
                                <img class="h-40" src="{{ Storage::url($moderation->data['bg_logo']) }}" alt="">
                            </div>
                        @endif

                        @if ($card['type'] == 'LEGAL')
                            <h3 class="flex items-center text-sm sm:text-base font-bold tracking-tight text-slate-800 dark:text-slate-200">
                                <svg class="w-5 h-5 text-slate-600 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $card['address'] }}
                            </h3>
                        @endif

                        @if ($company->site && $user->tariff && $user->tariff->can_site_link)
                            <a href="{{ $company->site }}" target="_blank" class="text-indigo-500 hover:text-indigo-600 flex items-center">
                                <svg class="w-5 h-5" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                        d="M4.37 7.657c2.063.528 2.396 2.806 3.202 3.87 1.07 1.413 2.075 1.228 3.192 2.644 1.805 2.289 1.312 5.705 1.312 6.705M20 15h-1a4 4 0 0 0-4 4v1M8.587 3.992c0 .822.112 1.886 1.515 2.58 1.402.693 2.918.351 2.918 2.334 0 .276 0 2.008 1.972 2.008 2.026.031 2.026-1.678 2.026-2.008 0-.65.527-.9 1.177-.9H20M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                {{ __('Company site') }}
                            </a>
                        @endif

                        <div class="my-5">
                            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                                <li class="text-slate-500">{{ __('Status') . ': ' }}<span
                                        class="text-slate-800 dark:text-slate-200">{{ $card['status'] }}</span>
                                </li>
                                <li class="text-slate-500">{{ __('TIN') . ': ' }}<span class="text-slate-800 dark:text-slate-200">{{ $card['inn'] }}</span>
                                </li>
                                <li class="text-slate-500">{{ __('OGRN') . ': ' }}<span class="text-slate-800 dark:text-slate-200">{{ $card['ogrn'] }}</span>
                                </li>
                                @if (array_key_exists('kpp', $card))
                                    <li class="text-slate-500">{{ __('KPP') . ': ' }}<span
                                            class="text-slate-800 dark:text-slate-200">{{ $card['kpp'] }}</span>
                                    </li>
                                @endif
                                <li class="text-slate-500">
                                    {{ __('Registration date') . ': ' }}<span class="date-transform text-slate-800 dark:text-slate-200" data-type="date"
                                        data-date="{{ $card['registration_date'] * 1000 }}"></span>
                                </li>
                                <li class="text-slate-500">{{ __('Employee count') . ': ' }}<span
                                        class="text-slate-800 dark:text-slate-200">{{ $card['employee_count'] ? $card['employee_count'] : 0 }}</span>
                                </li>

                                @if ($card['type'] == 'LEGAL')
                                    <li class="text-slate-500">
                                        {{ __('Authorized capital') . ': ' }}<span class="text-slate-800 dark:text-slate-200">{{ $card['capital'] }}
                                            ₽</span>
                                    </li>

                                    <div class="text-sm md:text-lg text-slate-800 dark:text-slate-200 font-semibold mt-3">
                                        {{ __('Founders') }}</div>

                                    @foreach ($card['founders'] as $founder)
                                        <div class="ml-4">
                                            <li class="text-slate-500">{{ __('Name') . ': ' }}<span
                                                    class="text-slate-800 dark:text-slate-200">{{ $founder['name'] }}
                                                    ({{ $founder['share'] }}%)
                                                </span>
                                            </li>
                                            <li class="text-slate-500 mt-1">
                                                {{ __('TIN') . ': ' }}<span class="text-slate-800 dark:text-slate-200">{{ $founder['inn'] }}</span>
                                            </li>
                                        </div>
                                    @endforeach
                                @endif

                                @if (array_key_exists('managers', $card))
                                    <div class="text-sm md:text-lg text-slate-800 dark:text-slate-200 font-semibold mt-3">
                                        {{ __('Managers') }}
                                    </div>

                                    @foreach ($card['managers'] as $manager)
                                        <div class="ml-4">
                                            <li class="text-slate-500">{{ __('Name') . ': ' }}<span
                                                    class="text-slate-800 dark:text-slate-200">{{ $manager['name'] }}</span>
                                            </li>
                                            <li class="text-slate-500 mt-1">
                                                {{ __('TIN') . ': ' }}<span class="text-slate-800 dark:text-slate-200">{{ $manager['inn'] }}</span>
                                            </li>
                                        </div>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                        @foreach ($company->documents as $document)
                            <x-document :path="Storage::url($document['path'])" :name="$document['name']"></x-document>
                        @endforeach
                    </div>

                    @php
                        $v = isset($moderation->data['video']) ? $moderation->data['video'] : $company->video;
                        $d = isset($moderation->data['description']) ? $moderation->data['description'] : $company->description;
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
                            <h2 class="font-extrabold tracking-tight text-slate-800 dark:text-slate-200 mt-8">
                                {{ __('Description') }}</h2>

                            <div itemprop="description"
                                class="ql-editor mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-800 dark:text-slate-200{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
                                {!! $d !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        @if (!isset($moderation))
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-10">
                @include('company.components.tf')
            </div>
        @endif

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-10 mt-2 sm:mt-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-6">
                @if (count($company->images))
                    <div class="sm:border-r border-slate-300 dark:border-slate-700 sm:pr-6">
                        <x-carousel :images="$company->images" min="128" max="128"></x-carousel>
                    </div>
                @endif

                <div class="space-y-5">
                    <h1 class="text-xl sm:text-2xl text-slate-800 dark:text-slate-200">{{ $company->name }}</h1>

                    @if ($card['type'] == 'LEGAL')
                        <h3 class="flex items-center text-sm sm:text-base font-bold tracking-tight text-slate-800 dark:text-slate-200">
                            <svg class="w-5 h-5 text-slate-600 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $card['address'] }}
                        </h3>
                    @endif

                    <x-characteristics.characteristics>
                        <x-characteristics.characteristic name="Status" :value="$card['status']" />
                        <x-characteristics.characteristic name="TIN" :value="$card['inn']" />
                        <x-characteristics.characteristic name="OGRN" :value="$card['ogrn']" />
                        @if (array_key_exists('kpp', $card))
                            <x-characteristics.characteristic name="KPP" :value="$card['kpp']" />
                        @endif
                        <x-characteristics.characteristic name="Registration date" :value="Carbon\Carbon::createFromTimestamp($card['registration_date'])->translatedFormat('d F Y')" />
                        <x-characteristics.characteristic name="Employee count" :value="$card['employee_count'] ?? 0" />
                        @if ($card['type'] == 'LEGAL')
                            <x-characteristics.characteristic name="Authorized capital" :value="$card['capital'] . ' ₽'" />
                        @endif
                    </x-characteristics.characteristics>
                </div>

                <div>
                    @if ($auth && $user->id == $auth->id)
                        <a class="block mt-6" href="{{ route('company.edit', ['company' => $company->id]) }}">
                            <x-buttons.primary-button>{{ __('Edit') }}</x-buttons.primary-button>
                        </a>
                    @else
                        <a class="block mt-6" target="_blank" href="{{ route('chat.start', ['user' => $user->id]) }}">
                            <x-buttons.primary-button>{{ __('Contact') }}</x-buttons.primary-button>
                        </a>
                    @endif
                </div>
            </div>

            @if (count($company->documents))
                <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                    @foreach ($company->documents as $document)
                        <x-document :path="Storage::url($document['path'])" :name="$document['name']"></x-document>
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

            <div class="mt-8" x-data="{ selectedTab: 'information' }">
                <div
                    class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 dark:text-slate-400 border-b border-slate-300 dark:border-slate-700">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'information'"
                                :class="{
                                    'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'information' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'information' ==
                                        selectedTab
                                }">
                                {{ __('Information') }}
                            </button>
                        </li>
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'reviews'"
                                :class="{
                                    'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'reviews' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'reviews' ==
                                        selectedTab
                                }">
                                {{ __('Reviews') }}
                            </button>
                        </li>
                        <li>
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'location'"
                                :class="{
                                    'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'location' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'location' ==
                                        selectedTab
                                }">
                                {{ __('Location') }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div x-show="selectedTab == 'information'">
                    <x-can-trust :user="$user" :id="$company->id" />

                    <div class="grid md:grid-cols-2 gap-4 md:gap-6">
                        @if ($card['type'] == 'LEGAL')
                            <div>
                                <div class="text-sm md:text-lg text-slate-800 dark:text-slate-200 font-semibold mb-3">
                                    {{ __('Founders') }}
                                </div>

                                @foreach ($card['founders'] as $founder)
                                    <x-characteristics.characteristics>
                                        <x-characteristics.characteristic name="Name" :value="$founder['name']" />
                                        <x-characteristics.characteristic name="Company share" :value="$founder['share'] . '%'" />
                                        <x-characteristics.characteristic name="TIN" :value="$founder['inn']" />
                                    </x-characteristics.characteristics>
                                @endforeach
                            </div>
                        @endif

                        @if (array_key_exists('managers', $card))
                            <div>
                                <div class="text-sm md:text-lg text-slate-800 dark:text-slate-200 font-semibold mb-3">
                                    {{ __('Managers') }}
                                </div>

                                @foreach ($card['managers'] as $manager)
                                    <x-characteristics.characteristics>
                                        <x-characteristics.characteristic name="Name" :value="$manager['name']" />
                                        <x-characteristics.characteristic name="TIN" :value="$manager['inn']" />
                                    </x-characteristics.characteristics>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6" x-show="selectedTab == 'reviews'" style="display: none">
                    @include('review.reviews', ['auth' => $auth, 'reviews' => $user->reviews])
                    @include('review.send', [
                        'auth' => $auth,
                        'reviews' => $user->reviews,
                        'type' => 'user',
                        'id' => $user->id,
                    ])
                </div>

                <div x-show="selectedTab == 'location'" style="display: none">
                    @include('ad.components.location', ['location' => $user->name . ', ' . $card['address']])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
