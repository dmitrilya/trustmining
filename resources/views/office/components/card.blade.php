<li class="sm:flex">
    <a class="block w-full" href="{{ route('office.edit', ['office' => $office->id]) }}">
        <x-carousel :images="$office->images"></x-carousel>
    </a>

    <div class="flex flex-col justify-between mt-3 sm:mt-0 sm:ml-6 w-full">
        <div>
            <p class="flex items-center text-sm sm:text-base font-semibold text-gray-900 mb-3 sm:mb-4">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-gray-500 mr-2" aria-hidden="true" width="24" height="24"
                    fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd"
                        d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                        clip-rule="evenodd" />
                </svg>
                {{ $office->address }}
            </p>

            <a href="{{ route('company', ['user' => $office->user->url_name]) }}"
                class="block hover:underline text-xs md:text-sm text-indigo-600 hover:text-indigo-500">{{ $office->user->name }}</a>

            <p class="mt-1 md:mt-2 mb-3 sm:mb-4 text-xxs sm:text-xs md:text-sm text-gray-400">
                {{ __('Trust Factor') }}: <span
                    class="font-bold {{ $office->user->tf > 60 ? ($office->user->tf > 80 ? 'text-green-500' : 'text-yellow-300') : 'text-red-600' }}">{{ $office->user->tf }}</span>
            </p>

            <x-peculiarities :ps="$office->peculiarities" model="office"></x-peculiarities>
        </div>

        <div class="flex flex-col sm:flex-row sm:ml-auto mt-3">
            <a class="block w-full sm:w-auto"
                href="{{ route('company.office', ['user' => $office->user->url_name, 'office' => $office->id]) }}">
                <x-primary-button
                    class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
            </a>

            @if ($auth && $auth->id == $office->user->id)
                <a class="block w-full sm:w-auto sm:ml-2" href="{{ route('office.edit', ['office' => $office->id]) }}">
                    <x-primary-button class="w-full">{{ __('Edit') }}</x-primary-button>
                </a>
            @endif
        </div>
    </div>
</li>
