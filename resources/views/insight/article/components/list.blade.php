@foreach ($articles as $article)
    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <meta itemprop="position" content="{{ $loop->iteration }}" />

        @include('insight.article.components.card')
    </div>
@endforeach
