<div class="{{ $relative ?? false ? 'relative ' : '' }}flex items-center h-full text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out"
    x-data="{ open: false }" @if (!isset($relative) || !$relative) @mouseover="open = true" @mouseleave="open = false" @endif>
    <button class="{{ $classes }}" @click="open = ! open">
        <div>{{ __('Advertisements') }}</div>

        <div class="ml-1">
            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </div>
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-50" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-50"
        class="w-full absolute z-50 rounded-md shadow-lg origin-top left-0 top-0 mt-10 lg:mt-14" style="display: none"
        @click.away="open = false">
        <div class="rounded-b-2xl ring-b-1 ring-black ring-opacity-5 p-4 lg:pb-10 lg:px-8 lg:pt-8 xl:pb-14 xl:px-12 xl:pt-12 bg-white dark:bg-zinc-900">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                <a href="{{ route('ads') }}" class="flex items-center group">
                    <img src="{{ Storage::url('public/menu/asics.webp') }}" alt="" class="w-10 xs:w-14 sm:w-16 lg:w-20 mr-1 xs:mr-2 lg:mr-3">
                    <h4 class="text-xs xs:text-sm lg:text-base text-gray-700 group-hover:text-gray-600 dark:text-gray-200 group-hover:dark:text-gray-300 font-bold">{{ __('Miners') }}</h4>
                </a>
                <a href="{{ route('hostings') }}" class="flex items-center group">
                    <img src="{{ Storage::url('public/menu/hostings.webp') }}" alt="" class="w-10 xs:w-14 sm:w-16 lg:w-20 mr-1 xs:mr-2 lg:mr-3">
                    <h4 class="text-xs xs:text-sm lg:text-base text-gray-700 group-hover:text-gray-600 dark:text-gray-200 group-hover:dark:text-gray-300 font-bold">{{ __('Hostings') }}</h4>
                </a>
                <a href="{{ route('services') }}" class="flex items-center group">
                    <img src="{{ Storage::url('public/menu/services.webp') }}" alt="" class="w-10 xs:w-14 sm:w-16 lg:w-20 mr-1 xs:mr-2 lg:mr-3">
                    <h4 class="text-xs xs:text-sm lg:text-base text-gray-700 group-hover:text-gray-600 dark:text-gray-200 group-hover:dark:text-gray-300 font-bold">{{ __('Services') }}</h4>
                </a>
            </div>
        </div>
    </div>
</div>
