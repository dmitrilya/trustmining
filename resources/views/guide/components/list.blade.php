<div class="flex">
    <fieldset aria-label="Choose a ad" class="w-full">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($guides as $guide)
                <div class="bg-white shadow-md overflow-hidden rounded-lg flex-col justify-between">
                    @include('guide.components.card')
                </div>
            @endforeach
        </div>
    </fieldset>
</div>
