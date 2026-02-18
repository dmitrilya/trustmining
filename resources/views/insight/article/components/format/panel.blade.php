@vite(['resources/js/format.js'])

<div class="flex flex-wrap gap-1 sm:gap-1.5 items-center py-3 position-sticky">
    @foreach ($blocks as $block)
        @include('insight.article.components.format.' . $block)
    @endforeach
</div>
