<div class="relative max-w-full overflow-hidden select-none" x-data="carousel()" @mousedown="start" @touchstart="start"
    @mousemove.window="move" @mouseup.window="end" @touchend.window="end" @mouseleave="end">

    <div x-ref="container"
        class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar cursor-grab active:cursor-grabbing"
        @if ($model != 'series') x-init="new InfiniteLoader({ container: $el, endpoint: '{{ $endpoint }}', page: 1, lastPage: {{ $items->lastPage() }} });" @endif>

        @include('insight.components.carousel-list')
    </div>
</div>
