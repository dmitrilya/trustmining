<div>
    @inject('articleService', 'App\Services\Insight\Content\ArticleService')

    @foreach ($articleService->getPopular(\App\Models\Insight\Content\Article::class, 1, '1 week') as $article)
        @include('insight.article.components.card')
    @endforeach
</div>
