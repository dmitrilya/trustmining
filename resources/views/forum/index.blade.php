<x-app-layout title="Каталог ASIC майнеров"
    description="ASIC майнеры. Цены, характеристики, расчет доходности, реальные отзывы, фото. Каталог моделей.">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <nav aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center space-x-2">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="1" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="text-gray-600 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-300">
                                <span itemprop="name">{{ __('Forum') }}</span>
                            </a>
                        </div>
                    </li>
                </ol>
            </nav>

            <x-primary-button>
                <a href="{{ route('forum.question.create') }}">{{ __('New question') }}</a>
            </x-primary-button>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-3 sm:space-y-5 lg:space-y-7">
        @foreach ($categories as $category)
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg">
                <h2 class="mb-1 sm:mb-3 lg:mb-5 p-4 md:p-6">
                    <a href="{{ route('forum.category', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name))]) }}"
                        class="xs:text-lg sm:text-xl lg:text-2xl text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                        {{ __($category->name) }}
                    </a>
                </h2>

                <div class="divide-y divide-gray-100 dark:divide-zinc-800">
                    @foreach ($category->forumSubcategories as $subcategory)
                        <a
                            href="{{ route('forum.subcategory', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name)), 'forumSubcategory' => strtolower(str_replace(' ', '_', $subcategory->name))]) }}">
                            <div
                                class="px-4 py-2 xs:py-3 sm:px-6 sm:py-4 lg:py-6 group hover:bg-gray-200 dark:hover:bg-zinc-950 flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="mr-3 sm:mr-4 size-8 min-w-8 sm:size-12 sm:min-w-12 lg:size-16 lg:min-w-16 rounded-full group-hover:shadow-lg dark:shadow-zinc-800 border-[1.5px] border-gray-500 dark:border-zinc-500 group-hover:border-gray-900 dark:group-hover:border-zinc-100 flex items-center justify-center">
                                        @include('layouts.components.svg.hosting', [
                                            'class' =>
                                                'text-gray-500 dark:text-zinc-500 group-hover:text-gray-900 dark:group-hover:text-zinc-100',
                                            'w' => '60%',
                                        ])
                                    </div>

                                    <h3
                                        class="text-xs xs:text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 font-bold">
                                        {{ __($subcategory->name) }}

                                    </h3>
                                </div>

                                <div class="ml-3 sm:ml-4 text-xs xs:text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 group-hover:text-gray-800 dark:group-hover:text-gray-200 font-bold text-right">Постов:<br />100</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
