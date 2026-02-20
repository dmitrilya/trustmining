<x-insight-layout title="TM Insight: видео, обзоры оборудования, отзывы"
    description="База знаний по майнингу: подробные обзоры ASIC-майнеров, видеокарт и комплектующих. Полезные статьи и инструкции от экспертов и сообщества. Узнайте, как эффективно добывать криптовалюту."
    :header="__('Videos')" itemtype="https://schema.org/CollectionPage" :itemname="__('Videos')">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/ItemList" id="infinite-loader"
        class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 xxxl:grid-cols-4"
        x-init="new InfiniteLoader({ endpoint: '{{ route('insight.video.index') }}', page: {{ $videos->currentPage() }}, lastPage: {{ $videos->lastPage() }} });">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.video.components.list')
    </div>
</x-insight-layout>
