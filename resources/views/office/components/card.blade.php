<li class="h-full">
    <p class="hidden sm:flex items-center text-sm font-semibold text-slate-800 dark:text-slate-200 mb-6">
        <svg class="min-w-4 w-4 h-4 sm:min-w-6 sm:w-6 sm:h-6 text-slate-600 mr-2" aria-hidden="true" width="24"
            height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd"
                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                clip-rule="evenodd" />
        </svg>
        {{ $office->address }}
    </p>

    <div class="h-full sm:h-auto flex flex-col justify-between sm:grid grid-cols-2 gap-3 sm:gap-6 xl:gap-4">
        <x-carousel :images="$office->images" model="office_card"></x-carousel>

        <div class="flex flex-col justify-between w-full">
            <div>
                <p class="flex sm:hidden items-center text-xs font-semibold text-slate-800 dark:text-slate-200 mb-3">
                    <svg class="min-w-4 w-4 h-4 sm:min-w-6 sm:w-6 sm:h-6 text-slate-600 mr-2" aria-hidden="true"
                        width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $office->address }}
                </p>

                <a href="{{ route('company', ['user' => $office->user->url_name]) }}"
                    class="block hover:underline text-xs md:text-sm text-indigo-600 hover:text-indigo-500">{{ $office->user->name }}</a>

                <div class="flex items-center mt-1 md:mt-2 mb-3 sm:mb-4">
                    <div
                        class="trust mr-1 sm:mr-2 size-3 md:size-4 rounded-full border border-slate-300 dark:border-slate-700 {{ $office->user->tf > config('trustfactor.yellow') ? ($office->user->tf > config('trustfactor.green') ? 'bg-green-500' : 'bg-yellow-300') : 'bg-red-600' }}">
                    </div>
                    <p class="text-xxs sm:text-xs md:text-sm text-slate-500">Trust Factor</p>
                </div>

                <x-peculiarities :ps="$office->peculiarities" model="office"></x-peculiarities>
            </div>

            <div class="flex flex-col sm:flex-row sm:ml-auto mt-3">
                <a class="block w-full sm:w-auto"
                    href="{{ route('company.office', ['user' => $office->user->url_name, 'office' => $office->id]) }}">
                    <x-primary-button
                        class="w-full justify-center text-xxs xs:text-xs">{{ __('Details') }}</x-primary-button>
                </a>

                @if ($auth && $auth->id == $office->user->id)
                    <a class="block w-full sm:w-auto mt-1 sm:mt-0 sm:ml-2"
                        href="{{ route('office.edit', ['office' => $office->id]) }}">
                        <x-primary-button class="w-full">{{ __('Edit') }}</x-primary-button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</li>
