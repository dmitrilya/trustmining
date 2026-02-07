@props([
    'contentClass' => '',
])

<div {{ $attributes->merge(['class' => 'relative bg-white/30 dark:bg-white/10 border border-white/60 dark:border-white/10 duration-100 overflow-hidden']) }}>
    <div class="backdrop-blur-2xl absolute z-10 w-full h-full"></div>
    <div class="relative z-20 h-full {{ $contentClass }}">{{ $slot }}</div>
</div>
