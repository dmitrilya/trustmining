<x-insight-layout title="TM Insight - экспертное медиа о крипте, майнинге и оборудовании"
    description="TM Insight - ведущая медиа-платформа о криптовалютах и майнинге. Экспертные статьи, рыночная аналитика, трейдинг, оборудование и корпоративные каналы"
    header="TM Insight" itemtype="https://schema.org/WebPage" :itemname="'TM Insight ' . __('Home')">
    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/ItemList">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.components.content', [
            'title' => 'Articles',
            'model' => 'article',
            'items' => [$newArticles, $popularArticles],
            'route' => 'insight.content.get',
            'routeData' => [],
        ])

        @include('insight.components.content', [
            'title' => 'Posts',
            'model' => 'post',
            'items' => [$newPosts, $popularPosts],
            'route' => 'insight.content.get',
            'routeData' => [],
        ])

        @include('insight.components.content', [
            'title' => 'Videos',
            'model' => 'video',
            'items' => [$newVideos, $popularVideos],
            'route' => 'insight.content.get',
            'routeData' => [],
        ])
    </div>
</x-insight-layout>
