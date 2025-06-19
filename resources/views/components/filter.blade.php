@props(['show'])

<div x-show="{{ !$show ? 'mobileFilter' : 'true' }}" x-data="{ mobile: {{ $show ? 'false' : 'true' }}, isSticky: false, lastKnownScrollPosition: window.pageYOffset }"
    class="p-4 sticky h-max w-full flex-col overflow-y-auto bg-white py-4 shadow-md{{ $show ? ' max-w-64 mr-4 hidden lg:flex rounded-lg' : ' pb-12 flex ml-auto' }}"
    x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" @if ($show)style="top: 32px"@endif
    @if (!$show) @click.away="mobileFilter = false" @endif
    @if ($show)
        @scroll.window="
            parentRect = $el.parentElement.getBoundingClientRect();
            parentTop = parentRect.top < 0 ? 0 : parentRect.top;
            parentBottom = parentRect.bottom > 0 ? window.innerHeight : window.innerHeight + parentRect.bottom;
            let rect = $el.getBoundingClientRect();

            if ($el.scrollHeight > parentBottom - parentTop || rect.top < 0 || rect.bottom > window.innerHeight) {
                if (window.pageYOffset > lastKnownScrollPosition) {
                    if (rect.bottom - window.innerHeight < -32) $el.style.top = window.innerHeight - $el.scrollHeight - 32 + 'px';
                    else $el.style.top = +$el.style.top.slice(0, -2) - (window.pageYOffset - lastKnownScrollPosition) + 'px';
                }
                else if (window.pageYOffset < lastKnownScrollPosition) {
                    if (rect.top > 31) $el.style.top = '32px';
                    else $el.style.top = +$el.style.top.slice(0, -2) - (window.pageYOffset - lastKnownScrollPosition) + 'px';
                }
            } else $el.style.top = '32px';
            lastKnownScrollPosition = window.pageYOffset;
        "
    @endif>
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
        @if ($sort)
            <input type="hidden" name="sort" value="{{ $sort }}">
        @endif

        {{ $slot }}

        {{-- <x-primary-button type="submit" class="w-full justify-center mt-6">{{ __('Apply') }}</x-primary-button> --}}

        <a href="{{ route(request()->route()->action['as'], request()->route()->originalParameters()) }}">
            <x-secondary-button type="button"
                class="w-full justify-center mt-2">{{ __('Reset') }}</x-secondary-button>
        </a>
    </form>
</div>
