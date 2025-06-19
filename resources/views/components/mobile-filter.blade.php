@props(['show'])

<div x-show="mobileFilter" class="relative z-40 lg:hidden" @if (!count(array_filter(request()->all(), fn($item) => $item != 'sort', ARRAY_FILTER_USE_KEY)))style="display: none" @endif role="dialog" aria-modal="true">
    <div x-show="mobileFilter" class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"
        x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="fixed inset-0 z-40 flex">
        <x-filter :show="$show">{{ $slot }}</x-filter>
    </div>
</div>
