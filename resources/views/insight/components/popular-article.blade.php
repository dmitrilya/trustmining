<div>
    @inject('articleService', 'App\Services\Insight\Content\ArticleService')

    <div itemprop="hasPart" itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @foreach ($articleService->getPopular(\App\Models\Insight\Content\Article::class, 1, '1 week') as $article)
            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <meta itemprop="position" content="{{ $loop->iteration }}" />

                @include('insight.article.components.card')
            </div>
        @endforeach
    </div>
</div>
