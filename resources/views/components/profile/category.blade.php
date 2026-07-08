<div {{ $attributes->merge(['class' => 'grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-5 items-start gap-2']) }}
    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100">
    {{ $slot }}
</div>
