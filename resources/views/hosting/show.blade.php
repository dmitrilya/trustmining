<x-app-layout>
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
                            class="flex items-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl{{ isset($moderation->data['city']) ? ' border border-indigo-500' : '' }}">
                            <svg class="w-6 h-6 text-gray-500 mr-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ isset($moderation->data['address']) ? $moderation->data['address'] : $hosting->address }}
                        </h1>

                        <p
                            class="text-3xl tracking-tight text-gray-900{{ isset($moderation->data['price']) ? ' border border-indigo-500' : '' }}">
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
                                    <li class="text-gray-400">{{ __('Conditions not specified') }}</li>
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
                                    <li class="text-gray-400">{{ __('Expenses not specified') }}</li>
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

                        @php
                            $d = isset($moderation->data['documents'])
                                ? $moderation->data['documents']
                                : $hosting->documents;
                        @endphp

                        @if (count($d))
                            <div
                                class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8{{ isset($moderation->data['documents']) ? ' border border-indigo-500' : '' }}">
                                @foreach ($d as $document)
                                    <x-document :path="$document['path']" :name="$document['name']"></x-document>
                                @endforeach
                            </div>
                        @endif

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
                    <h1 class="flex items-center text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">
                        <svg class="w-6 h-6 text-gray-500 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $hosting->address }}
                    </h1>

                    <p class="text-3xl tracking-tight text-gray-900">{{ $hosting->price }} ₽</p>

                    <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>

                    <div>
                        <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Conditions') }}</h3>

                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                            @if (!count($hosting->conditions))
                                <li class="text-gray-400">{{ __('Conditions not specified') }}</li>
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
                                <li class="text-gray-400">{{ __('Expenses not specified') }}</li>
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

                    @if (count($hosting->documents))
                        <div class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 mt-8">
                            @foreach ($hosting->documents as $document)
                                <x-document :path="$document['path']" :name="$document['name']"></x-document>
                            @endforeach
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
