<div class="flex flex-wrap lg:hidden gap-2 sm:gap-3 mb-4">
    @php
        $strokeWidth = 1.5;
    @endphp

    <div x-data="{ open: false }" @click.outside="open = false" class="relative inline-block">
        <div @click="open = !open"
            class="flex items-center cursor-pointer rounded-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color px-3 py-1.5 sm:px-4 sm:py-2">
            <svg class="text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-4 sm:size-5"
                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="{{ $strokeWidth }}"
                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
            </svg>

            <div
                class="ml-1 text-xs sm:text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
                {{ __('Publish') }}
            </div>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-2"
            class="absolute left-0 mt-2 w-48 origin-top-left rounded-2xl border border-gray-200 dark:border-zinc-700 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-xl shadow-xl z-50 overflow-hidden"
            style="display: none;">

            @include('insight.components.publish-menu')
        </div>
    </div>

    <div class="flex items-center cursor-pointer rounded-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color px-3 py-1.5 sm:px-4 sm:py-2"
        @click="$dispatch('open-modal', 'series-creation')">
        <svg class="text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-4 sm:size-5"
            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
            viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                stroke-width="{{ $strokeWidth }}"
                d="M14 17h6m-3 3v-6M4.857 4h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 9.143V4.857C4 4.384 4.384 4 4.857 4Zm10 0h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857h-4.286A.857.857 0 0 1 14 9.143V4.857c0-.473.384-.857.857-.857Zm-10 10h4.286c.473 0 .857.384.857.857v4.286a.857.857 0 0 1-.857.857H4.857A.857.857 0 0 1 4 19.143v-4.286c0-.473.384-.857.857-.857Z" />
        </svg>

        <div
            class="ml-1 text-xs sm:text-sm text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:dark:text-gray-200">
            {{ __('Create series') }}
        </div>
    </div>

    <a href="{{ route('insight.channel.statistics', ['channel' => $channel->slug]) }}"
        class="flex items-center cursor-pointer rounded-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color px-3 py-1.5 sm:px-4 sm:py-2">
        @if (request()->routeIs('insight.channel.statistics'))
            @include('insight.svg.statistics-active', [
                'svgClass' =>
                    'text-gray-800 dark:text-zinc-200 stroke-gray-800 dark:stroke-zinc-200 size-4 sm:size-5',
            ])

            <div class="ml-1 text-xs sm:text-sm text-gray-800 dark:text-gray-200">
                {{ __('Statistics') }}
            </div>
        @else
            @include('insight.svg.statistics', [
                'svgClass' =>
                    'text-gray-600 dark:text-zinc-400 stroke-gray-400 dark:stroke-zinc-600 size-4 sm:size-5',
            ])

            <div class="ml-1 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                {{ __('Statistics') }}
            </div>
        @endif
    </a>
</div>

<x-modal name="series-creation" maxWidth="md">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-gray-800 dark:text-gray-200">
                {{ __('Create series') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-zinc-950 text-gray-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="post" action="{{ route('insight.series.store', ['channel' => $channel->slug]) }}"
            x-data="{ errors: [] }"
            @submit.prevent="
                    if (Object.keys(errors).length > 0) {
                        pushToastAlert(Object.values(errors)[0], 'error');
                        $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
                    } else $el.submit();">
            @csrf

            <div class="w-full">
                <x-input-label for="series-name" :value="__('Series name')" />
                <x-length-input id="series-name" name="name" type="text" autocomplete="series-name" required
                    max="30" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <x-primary-button class="block ml-auto mt-6">{{ __('Create') }}</x-primary-button>
        </form>
    </div>
</x-modal>
