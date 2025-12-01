<x-app-layout title="Руководства: статьи, руководства для майнеров, отзывы и обзоры экспертов">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Guides') }}
            </h2>

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
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('guide.components.list')
    </div>
</x-app-layout>
