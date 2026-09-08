<li class="h-full">
    <p class="hidden sm:flex items-center text-sm font-semibold text-slate-800 dark:text-slate-200 mb-6">
        <svg class="min-w-4 w-4 h-4 sm:min-w-6 sm:w-6 sm:h-6 text-slate-600 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor"
            viewBox="0 0 24 24">
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
                    <svg class="min-w-4 w-4 h-4 sm:min-w-6 sm:w-6 sm:h-6 text-slate-600 mr-2" aria-hidden="true" width="24" height="24"
                        fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $office->address }}
                </p>

                <a href="{{ route('company', ['user' => $office->user->slug]) }}"
                    class="block hover:underline text-xs md:text-sm text-indigo-500 hover:text-indigo-600">{{ $office->user->name }}</a>

                <x-tf :tf="$office->user->tf" class="mt-1 md:mt-2 mb-3 sm:mb-4" />

                <x-peculiarities :ps="$office->peculiarities" model="office"></x-peculiarities>
            </div>

            <div class="flex flex-col sm:flex-row sm:ml-auto mt-3">
                <a class="block w-full sm:w-auto" href="{{ route('company.office', ['user' => $office->user->slug, 'office' => $office->id]) }}">
                    <x-buttons.primary-button class="w-full justify-center">{{ __('Details') }}</x-buttons.primary-button>
                </a>

                @if ($auth && $auth->id == $office->user->id)
                    <a class="block w-full sm:w-auto mt-1 sm:mt-0 sm:ml-2" href="{{ route('office.edit', ['office' => $office->id]) }}" aria-label="{{ __('Edit') }}">
                        <x-buttons.secondary-button class="w-full">
                            <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                        </x-buttons.secondary-button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</li>
