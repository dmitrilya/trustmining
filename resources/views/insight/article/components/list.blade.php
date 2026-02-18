<x-filter>@include('insight.article.components.filter')</x-filter>

<fieldset aria-label="Choose a article" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($articles as $article)
            @include('insight.article.components.card')
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $articles->links() }}
</div>

