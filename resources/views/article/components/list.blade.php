<div class="flex">
    <fieldset aria-label="Choose a ad" class="w-full">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($articles as $article)
                @include('article.components.card')
            @endforeach
        </div>
    </fieldset>
</div>
