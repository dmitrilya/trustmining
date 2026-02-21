@props(['ad', 'auth', 'hidden'])

<div
    class="sm:max-w-md h-full p-2 sm:px-4 sm:py-3 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-md shadow-logo-color overflow-hidden rounded-lg flex flex-col justify-between">
    <div>
        @if (count($hosting->images))
            <div class="w-full aspect-[4/3] overflow-hidden rounded-lg">
                <a class="block w-full" href="{{ route('company.hosting', ['user' => $hosting->user->url_name]) }}">
                    @php
                        $preview = explode('.', $hosting->images[0]);
                        $baseName = preg_replace('/_[0-9]+$/', '', $preview[0]);
                        $previewxs = $baseName . '_188' . '.' . $preview[1];
                        $previewsm = $baseName . '_368' . '.' . $preview[1];
                    @endphp

                    <picture>
                        <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                        <img class="w-full object-cover" src="{{ Storage::url($previewsm) }}" alt="Hosting preview">
                    </picture>
                </a>
            </div>
        @endif

        <a href="{{ route('company', ['user' => $hosting->user->url_name]) }}"
            class="block hover:underline text-xs sm:text-sm text-indigo-600 hover:text-indigo-500 mt-4">{{ $hosting->user->name }}</a>

        <div class="flex items-center my-1 md:my-2">
            <div
                class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-gray-300 dark:border-zinc-700 {{ $hosting->user->tf > config('trustfactor.yellow') ? ($hosting->user->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
            </div>
            <p class="text-xxs sm:text-xs md:text-sm text-gray-500">Trust Factor</p>
        </div>

        <div class="flex items-center my-2 sm:my-3 text-sm sm:text-base text-gray-950 dark:text-gray-50 font-bold">
            <svg class="w-4 h-4 text-gray-600 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                    clip-rule="evenodd" />
            </svg>
            {{ __($hosting->address) }}
        </div>

        <x-peculiarities :ps="$hosting->peculiarities" model="hosting"></x-peculiarities>
    </div>

    <div class="mt-2">
        @if ($hosting && $hosting->id == $hosting->user->id && $hosting->moderation)
            <div class="mt-2 sm:flex">
                <div
                    class="cursor-default inline-flex items-center px-2 py-1 bg-red-500 border border-red-500 rounded-md text-xxs text-white uppercase shadow-sm shadow-logo-color hover:bg-red-400 transition ease-in-out duration-150">
                    {{ __('Is under moderation') }}
                </div>
            </div>
        @endif

        <div class="sm:mt-2 text-gray-800 dark:text-gray-200 text-sm sm:text-lg font-bold">{{ $hosting->price }} ₽</div>

        <div class="relative flex mt-2 sm:mt-4 items-center">
            <a class="block w-full" href="{{ route('company.hosting', ['user' => $hosting->user->url_name]) }}">
                <x-primary-button class="w-full justify-center">{{ __('Details') }}</x-primary-button>
            </a>
        </div>
    </div>
</div>
