@php
    $sort = request()->sort ?? 'newest';
    $selectedTags = request()->input('tags', []);
    $tagsCount = count($selectedTags);
@endphp

<x-insight-layout title="TM Insight{{ $tagsCount === 1 ?  ' | ' . $selectedTags[0] : '' }}: статьи, руководства для майнеров, отзывы и обзоры экспертов"
    description="Главная база знаний о криптовалютах и майнинге{{ $tagsCount === 1 ? ' на тему ' . $selectedTags[0] : '' }}. Информационные статьи, пошаговые инструкции, прогнозы экспертов и обзоры рынка в одном месте | TM Insight"
    header="{{ __('Articles') }}{{ $tagsCount === 1 ? ' на тему ' . $selectedTags[0] : '' }}" itemtype="https://schema.org/CollectionPage" :itemname="__('Articles')" :noindex="$tagsCount > 1 ? 'true' : null">
    <x-slot name="sort">
        <x-filters.header-filters>
            <x-slot name="sort">
                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'newest' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'newest' ? null : 'newest',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Newest') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'oldest' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'oldest' ? null : 'oldest',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Oldest') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'more_likes' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'more_likes' ? null : 'more_likes',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('More likes') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'less_likes' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'less_likes' ? null : 'less_likes',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Less likes') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'more_views' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'more_views' ? null : 'more_views',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('More views') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-slate-200 dark:bg-slate-700': {{ $sort && $sort == 'less_views' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->getName(),
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'less_views' ? null : 'less_views',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Less views') }}
                </x-dropdown-link>
            </x-slot>
        </x-filters.header-filters>
    </x-slot>

    <x-filters.filter>@include('insight.article.components.filter')</x-filters.filter>

    <div itemprop="mainEntity" itemscope itemtype="https://schema.org/ItemList" id="infinite-loader"
        class="grid gap-1 xs:gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 xxxl:grid-cols-4"
        x-init="new InfiniteLoader({ endpoint: '{{ route('insight.article.index') }}', page: {{ $articles->currentPage() }}, lastPage: {{ $articles->lastPage() }} });">
        <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

        @include('insight.article.components.list')
    </div>

    <x-slot name="rightSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
