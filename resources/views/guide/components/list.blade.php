<x-filter>@include('guide.components.filter')</x-filter>

<fieldset aria-label="Choose a guide" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        @foreach ($guides as $guide)
            @include('guide.components.card')
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $guides->links() }}
</div>

