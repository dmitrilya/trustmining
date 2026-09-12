<x-insight-layout :title="__('meta.insight.title')" :description="__('meta.insight.description')" header="TM Insight" itemtype="https://schema.org/WebPage" :itemname="'TM Insight ' . __('Home')">
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

    <x-slot name="rightSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
