<x-app-layout title="Офис компании {{ $office->user->name }}, точка продаж ASIC майнеров в городе {{ $office->city }}" description="Посетите официальный офис компании {{ $office->user->name }} в городе {{ $office->city }}. В продаже ASIC-майнеры в наличии и под заказ, проверка оборудования на месте, гарантийное обслуживание и консультации экспертов. Узнайте адрес и режим работы прямо сейчас">
    <x-slot name="header">
        <div class="flex items-center">
            <x-back-link :href="route('company', ['user' => $office->user->url_name])"></x-back-link>

            <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight ml-3">
                {{ __('Office of company') }} {{ $office->user->name }}
            </h1>
        </div>
    </x-slot>

    @php
        $auth = Auth::user();
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @if (isset($moderation) && $auth && in_array($auth->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons')

            <div
                class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-7 gap-3 sm:gap-6">
                    <div
                        class="md:col-span-3 sm:border-r border-gray-300 dark:border-zinc-700 sm:pr-6{{ isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                        <x-carousel :images="isset($moderation->data['images']) ? $moderation->data['images'] : $office->images" min="128" max="128"></x-carousel>
                    </div>

                    <div
                        class="md:col-span-4 space-y-5">
                        <h3
                            class="flex items-center mb-4 text-sm font-bold tracking-tight text-gray-950 dark:text-gray-100 xs:text-base sm:text-lg{{ isset($moderation->data['address']) ? ' border border-indigo-500' : '' }}">
                            <svg class="min-w-4 w-4 h-4 sm:min-w-5 sm:w-5 sm:h-5 text-gray-600 mr-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ isset($moderation->data['address']) ? $moderation->data['address'] : $office->address }}
                        </h3>

                        <div class="{{ isset($moderation->data['peculiarities']) ? 'border border-indigo-500' : '' }}">
                            <x-peculiarities :ps="isset($moderation->data['peculiarities'])
                                ? $moderation->data['peculiarities']
                                : $office->peculiarities" model="office"></x-peculiarities>
                        </div>
                    </div>

                    <div class="mt-8 md:col-span-12">
                        @include('components.about-seller', ['user' => $office->user])

                        @php
                            $v = isset($moderation->data['video']) ? $moderation->data['video'] : $office->video;
                        @endphp

                        @if ($v)
                            <div
                                class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8{{ isset($moderation->data['video']) ? ' border border-indigo-500' : '' }}">
                                <iframe class="w-full h-full" src="{{ $v }}"
                                    allow="autoplay; encrypted-media; fullscreen; picture-in-picture; screen-wake-lock;"
                                    frameborder="0" allowfullscreen></iframe>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div
            class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-7 gap-3 sm:gap-6">
                <div class="md:col-span-3 sm:border-r border-gray-300 dark:border-zinc-700 sm:pr-6">
                    <x-carousel :images="$office->images" min="128" max="128"></x-carousel>
                </div>

                <div
                    class="md:col-span-4 space-y-5">
                    <h3
                        class="flex items-center mb-4 text-sm font-bold tracking-tight text-gray-950 dark:text-gray-100 xs:text-base sm:text-lg">
                        <svg class="min-w-4 w-4 h-4 sm:min-w-5 sm:w-5 sm:h-5 text-gray-600 mr-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $office->address }}
                    </h3>

                    <x-peculiarities :ps="$office->peculiarities" model="office"></x-peculiarities>

                    <div>
                        @if ($auth && $office->user->id == $auth->id)
                            <a class="block mt-6" href="{{ route('office.edit', ['office' => $office->id]) }}">
                                <x-primary-button>{{ __('Edit') }}</x-primary-button>
                            </a>
                        @else
                            <a class="block mt-6" target="_blank"
                                href="{{ route('chat.start', ['user' => $office->user->id]) }}">
                                <x-primary-button>{{ __('Contact') }}</x-primary-button>
                            </a>
                        @endif
                    </div>
                </div>

                <div class="mt-8 md:col-span-12">
                    @include('components.about-seller', ['user' => $office->user])

                    @if ($office->video)
                        <div class="w-full aspect-[16/9] overflow-hidden rounded-lg mt-8">
                            <iframe class="w-full h-full" src="{{ $office->video }}" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
