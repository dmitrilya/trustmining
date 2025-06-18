<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Offices') }}
            </h2>
        </div>
    </x-slot>

    @php
        $auth = Auth::user();
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-2 sm:p-4 md:p-6">
            @if (!$offices->count())
                <p class="text-base text-gray-500">
                    {{ __('There is no information about open offices and points of sale.') }}
                </p>
            @else
                <ul role="list" class="divide-y divide-gray-100">
                    @foreach ($offices as $office)
                        <li class="sm:flex">
                            <x-carousel :images="$office->images"></x-carousel>

                            <div class="flex flex-col justify-between sm:ml-6 mt-6 sm:mt-0 w-full">
                                <div>
                                    <p class="flex text-base font-semibold text-gray-900 mb-6">
                                        <svg class="w-6 h-6 text-gray-500 mr-2" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd"
                                                d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $office->address }}
                                    </p>

                                    <x-peculiarities :ps="$office->peculiarities"></x-peculiarities>
                                </div>

                                <div class="flex flex-col sm:flex-row sm:ml-auto">
                                    <a class="block w-full sm:w-auto mt-8 sm:mt-0"
                                        href="{{ route('company.office', ['user' => $office->user->url_name, 'office' => $office->id]) }}">
                                        <x-primary-button class="w-full">{{ __('Details') }}</x-primary-button>
                                    </a>

                                    @if ($auth && $auth->id == $office->user->id)
                                        <a class="block w-full sm:w-auto mt-2 sm:mt-0 sm:ml-2"
                                            href="{{ route('office.edit', ['office' => $office->id]) }}">
                                            <x-primary-button class="w-full">{{ __('Edit') }}</x-primary-button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-app-layout>
