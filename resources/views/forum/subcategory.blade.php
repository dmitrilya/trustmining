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
                            <a itemprop="item" href="{{ route('forum') }}"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __('Forum') }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('forum.category', ['forumCategory' => strtolower(str_replace(' ', '_', $category->name))]) }}"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __($category->name) }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="3" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="text-gray-600 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-300">
                                <span itemprop="name">{{ __($subcategory->name) }}</span>
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

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-4 md:p-6"
            x-data="{ search: '' }">
            @foreach ($questions as $question)
                <h2>
                    question
                </h2>
            @endforeach
        </div>
    </div>
</x-app-layout>
