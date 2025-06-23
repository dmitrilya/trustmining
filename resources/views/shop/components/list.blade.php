<x-filter>@include('shop.components.filter')</x-filter>

<fieldset aria-label="Choose a ad" class="w-full">
    <div class="grid gap-2 grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
        @foreach ($shops as $shop)
            @include('shop.components.card')
        @endforeach
    </div>
</fieldset>
