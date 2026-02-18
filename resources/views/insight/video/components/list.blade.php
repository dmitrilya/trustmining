<fieldset aria-label="Choose a video" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($videos as $video)
            @include('insight.video.components.card')
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $videos->links() }}
</div>

