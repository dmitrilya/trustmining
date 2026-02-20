<x-insight-layout title="TM Insight: посты, новостии идеи"
    description="База знаний по майнингу: подробные обзоры ASIC-майнеров, видеокарт и комплектующих. Полезные статьи и инструкции от экспертов и сообщества. Узнайте, как эффективно добывать криптовалюту."
    :header="__('Posts')" itemtype="https://schema.org/CollectionPage" :itemname="__('Posts')">
    <div itemscope itemtype="https://schema.org/ItemList" id="infinite-loader"
        class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 xxxl:grid-cols-4"
        x-init="new InfiniteLoader({ endpoint: '{{ route('insight.post.index') }}', page: {{ $posts->currentPage() }}, lastPage: {{ $posts->lastPage() }} });">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.post.components.list')
    </div>
</x-insight-layout>
