@props(['show'])

<div x-show="{{ !$show ? 'mobileFilter' : 'true' }}"
    class="p-4 relative h-full w-full flex-col overflow-y-auto bg-white py-4 shadow-md{{ $show ? ' max-w-64 mr-4 hidden lg:flex rounded-lg' : ' max-w-xs pb-12 flex ml-auto' }}"
    x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
    @if (!$show) @click.away="mobileFilter = false" @endif>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-gray-900">{{ __('Filters') }}</h2>

        @if (!$show)
            <button type="button"
                class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                @click="mobileFilter = false">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>

    @php
        $sort = request()->sort;
    @endphp

    <form class="mt-4 pt-4"
        action="{{ route(request()->route()->action['as'], request()->route()->originalParameters()) }}">
        {{ $slot }}

        <div class="w-full mt-6">
            <x-secondary-button type="submit" class="w-full justify-center">{{ __('Apply') }}</x-secondary-button>
        </div>
    </form>
</div>
