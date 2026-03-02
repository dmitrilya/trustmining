<div>
    <p class="ml-2 mb-2 sm:mb-4 text-base text-slate-700 dark:text-slate-300 font-bold ">
        {{ __('Top weekly article') }}</p>

    @inject('articleService', 'App\Services\Insight\Content\ArticleService')

    <div itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="name" content="Articles in sidebar" />
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @foreach ($articleService->getPopular(\App\Models\Insight\Content\Article::class, 1, '1 week') as $article)
            <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <meta itemprop="position" content="{{ $loop->iteration }}" />

                @include('insight.article.components.card')
            </div>
        @endforeach
    </div>
</div>
