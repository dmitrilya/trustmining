<div class="flex">
    <fieldset aria-label="Choose a ad">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($articles as $article)
                <div class="bg-white shadow-md overflow-hidden rounded-lg flex-col justify-between">
                    @include('article.components.card')
                </div>
            @endforeach
        </div>
    </fieldset>
</div>
