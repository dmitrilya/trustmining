<div class="{{ $relative ?? false ? 'relative ' : '' }}flex items-center h-full text-sm leading-5 text-slate-600 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none focus:text-slate-700 dark:focus:text-slate-300 transition duration-150 ease-in-out"
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
        class="w-full absolute z-50 rounded-b-2xl shadow-lg shadow-logo-color backdrop-blur-2xl origin-top left-0 top-0 mt-10 lg:mt-14"
        style="display: none" @click.away="open = false">
        <div
            class="ring-b-1 ring-black ring-opacity-5 p-4 lg:pb-10 lg:px-8 lg:pt-8 xl:pb-14 xl:px-12 xl:pt-12 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700">
            <div class="grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-6 lg:grid-cols-8 gap-3 sm:gap-4">
                @include('layouts.components.ad-categories')
            </div>
        </div>
    </div>
</div>
