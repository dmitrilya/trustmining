<x-insight-layout title="TM Insight: статьи, руководства для майнеров, отзывы и обзоры экспертов"
    description="База знаний по майнингу: подробные обзоры ASIC-майнеров, видеокарт и комплектующих. Полезные статьи и инструкции от экспертов и сообщества. Узнайте, как эффективно добывать криптовалюту."
    :header="__('Articles')">
    <x-slot name="sort">
        @php
            $sort = request()->sort ?? 'newest';
        @endphp

        <x-header-filters>
            <x-slot name="sort">
                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'newest' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'newest' ? null : 'newest',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Newest') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'oldest' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'oldest' ? null : 'oldest',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Oldest') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'more_likes' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'more_likes' ? null : 'more_likes',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('More likes') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'less_likes' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'less_likes' ? null : 'less_likes',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Less likes') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'more_views' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'more_views' ? null : 'more_views',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('More views') }}
                </x-dropdown-link>

                <x-dropdown-link ::class="{ 'bg-gray-200 dark:bg-zinc-700': {{ $sort && $sort == 'less_views' ? 'true' : 'false' }} }" :href="route(
                    request()->route()->action['as'],
                    array_merge(request()->route()->originalParameters(), [
                        'sort' => $sort && $sort == 'less_views' ? null : 'less_views',
                        http_build_query(request()->except('sort')),
                    ]),
                )">
                    {{ __('Less views') }}
                </x-dropdown-link>
            </x-slot>
        </x-header-filters>
    </x-slot>

    @include('insight.article.components.list')
</x-insight-layout>
