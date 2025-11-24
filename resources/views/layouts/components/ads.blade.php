<div class="{{ $relative ?? false ? 'relative ' : '' }}flex items-center h-full text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 transition duration-150 ease-in-out"
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
        class="w-full absolute z-50 rounded-b-2xl shadow-lg dark:shadow-zinc-800 origin-top left-0 top-0 mt-10 lg:mt-14"
        style="display: none" @click.away="open = false">
        <div
            class="ring-b-1 ring-black ring-opacity-5 p-4 lg:pb-10 lg:px-8 lg:pt-8 xl:pb-14 xl:px-12 xl:pt-12 bg-white dark:bg-zinc-900">
            <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 xl:grid-cols-10 gap-3 sm:gap-4">
                <a href="{{ route('ads', ['adCategory' => 'miners']) }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.miner', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '50%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Miners') }}</h4>
                </a>
                <a href="{{ route('hostings') }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.hosting', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '60%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Hostings') }}</h4>
                </a>
                <a href="{{ route('services') }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.service', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '55%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Services') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'legals']) }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.legal', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '50%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Legals') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'containers']) }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.container', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '65%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Containers') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'noiseboxes']) }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.noisebox', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '50%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Noiseboxes') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'cryptoboilers']) }}"
                    class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.cryptoboiler', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '50%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Cryptoboilers') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'water_cooling_plates']) }}"
                    class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.water_cooling_plate', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '50%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Water cooling plates') }}</h4>
                </a>
                <a href="{{ route('cryptoexchangers') }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.cryptoexchanger', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '55%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Cryptoexchangers') }}</h4>
                </a>
                <a href="{{ route('ads', ['adCategory' => 'accessories']) }}" class="flex flex-col items-center group">
                    <div
                        class="mb-3 sm:mb-4 xl:mb-5 size-16 sm:size-20 md:size-24 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 group-hover:border-gray-900 dark:group-hover:border-gray-100 flex items-center justify-center">
                        @include('layouts.components.svg.accessories', [
                            'class' => 'text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100',
                            'w' => '55%',
                        ])
                    </div>
                    <h4
                        class="text-xs xs:text-sm lg:text-base text-gray-500 group-hover:text-gray-900 dark:group-hover:text-gray-100 font-bold">
                        {{ __('Accessories') }}</h4>
                </a>
            </div>
        </div>
    </div>
</div>
