<div class="flex flex-wrap gap-1 sm:gap-1.5 items-center py-3 position-sticky">
    @foreach ($blocks as $block)
        @include('guide.components.format.' . $block)
    @endforeach
</div>
