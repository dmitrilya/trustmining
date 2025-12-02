<x-app-layout title="Каталог ASIC майнеров"
    description="ASIC майнеры. Цены, характеристики, расчет доходности, реальные отзывы, фото. Каталог моделей.">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-4 md:p-6"
            x-data="{ search: '' }">
            <nav class="mb-3" aria-label="Breadcrumb">
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

            @foreach ($categories as $category)
                <h2>
                    <a href="{{ route('forum.category', ['forumCategory' => tolowercase(str_replace(' ', '_', $category->name))]) }}"
                        class="under xs:text-lg sm:text-xl lg:text-2xl text-gray-700:dark-text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                        {{ __($category->name) }}
                    </a>
                </h2>

                @foreach ($category->forumSubcategories as $subcategory)
                    <h2>
                    <a href="{{ route('forum.subcategory', ['forumCategory' => tolowercase(str_replace(' ', '_', $category->name))]) }}"
                        class="under xs:text-lg sm:text-xl lg:text-2xl text-gray-700:dark-text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-bold">
                        {{ __($category->name) }}
                    </a>
                </h2>
                @endforeach
            @endforeach
        </div>
    </div>
</x-app-layout>
