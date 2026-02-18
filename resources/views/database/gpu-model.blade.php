<x-app-layout :title="'ГПУ ' . $brand->name . ' ' . $model->name" :description="'Газопоршневая установка от производителя ' .
    $brand->name .
    ' модели ' .
    $model->name .
    '. Цены, характеристики, расчет доходности, реальные отзывы, фото. Каталог моделей'">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-4 md:p-6">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center space-x-1 sm:space-x-2">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="1" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __('Catalog of gpus') }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item" href="#"
                                class="sm:mr-2 text-sm text-gray-900 dark:text-gray-100 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ $brand->name }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="3" />
                        <a itemprop="item" href="#" aria-current="page"
                            class="text-gray-600 dark:text-gray-300 hover:text-gray-600 dark:hover:text-gray-300">
                            <span itemprop="name">{{ $model->name }}</span>
                        </a>
                    </li>
                </ol>
            </nav>

            @include('database.components.gpu-model-images')

            <div itemscope itemtype="https://schema.org/Product"
                class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] mt-6 md:mt-12">
                <div class="md:col-span-2 md:border-r border-gray-300 dark:border-zinc-700 md:pr-8">
                    <h1 itemprop="name"
                        class="text-xl font-bold tracking-tight text-gray-950 dark:text-gray-100 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>
                </div>

                @php
                    $hasTariff = ($user = Auth::user()) && $user->tariff;
                    $momentRating = $model->moderatedReviews->count() ? $model->moderatedReviews->avg('rating') : 0;
                    $modelAds = $model->ads;
                    $modelAdWithMinPrice = $modelAds->where('price', '!=', 0)->sortBy('price')->first();
                    $reviewsCount = $model->moderatedReviews->count();
                @endphp

                <div class="mt-4 md:row-span-3 md:mt-0 md:pl-6 lg:pl-12 xl:pl-16">
                    <h2 class="sr-only">Информация</h2>

                    <!-- Reviews -->
                    @if ($reviewsCount)
                        <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"
                            class="mt-4 sm:mt-6">
                            <h3 class="sr-only">{{ __('Reviews') }}</h3>
                            <div class="flex items-center" x-data="{ momentRating: {{ $momentRating }} }">
                                <x-rating></x-rating>
                                <meta itemprop="ratingValue" content="{{ $momentRating }}" />
                                <meta itemprop="worstRating" content="1" />
                                <meta itemprop="bestRating" content="5" />

                                <a itemprop="url"
                                    href="{{ route('database.reviews', [
                                        'gpuBrand' => strtolower(str_replace(' ', '_', $brand->name)),
                                        'gpuModel' => strtolower(str_replace(' ', '_', $model->name)),
                                    ]) }}"
                                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                    <span itemprop="reviewCount">{{ $reviewsCount }}</span>
                                    {{ __('reviews') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 sm:mt-6">
                            <h3 class="sr-only">{{ __('Reviews') }}</h3>
                            <div class="flex items-center" x-data="{ momentRating: {{ $momentRating }} }">
                                <x-rating></x-rating>

                                <a href="{{ route('database.gpu.reviews', [
                                    'gpuBrand' => strtolower(str_replace(' ', '_', $brand->name)),
                                    'gpuModel' => strtolower(str_replace(' ', '_', $model->name)),
                                ]) }}"
                                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">{{ $reviewsCount }}
                                    {{ __('reviews') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if ($modelAds->count() && $modelAdWithMinPrice)
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <meta itemprop="lowPrice" content="{{ $modelAdWithMinPrice->price }}" />
                            <meta itemprop="priceCurrency"
                                content="{{ $modelAdWithMinPrice->coin->abbreviation == 'USDT' ? 'USD' : $modelAdWithMinPrice->coin->abbreviation }}" />

                            <a itemprop="url" class="w-full xs:w-max mt-4 sm:mt-6 md:mt-8"
                                href="{{ route('ads', ['adCategory' => 'gpus', 'gpu_model' => strtolower(str_replace(' ', '_', $model->name))]) }}">
                                <x-primary-button class="w-full">{{ __('Find ads') }}</x-primary-button>
                            </a>
                        </div>
                    @else
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <meta itemprop="lowPrice" content="0" />
                            <meta itemprop="priceCurrency" content="RUB" />
                            <link itemprop="url"
                                href="{{ route('ads', ['adCategory' => 'gpus', 'gpu_model' => strtolower(str_replace(' ', '_', $model->name))]) }}" />
                        </div>

                        <x-primary-button
                            class="mt-4 sm:mt-6 md:mt-8 cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                    @endif
                </div>

                <div
                    class="py-6 sm:py-8 md:col-span-2 md:col-start-1 md:border-r border-gray-300 dark:border-zinc-700 md:pb-16 md:pr-8 md:pt-6">
                    <div itemprop="manufacturer" itemscope itemtype="http://schema.org/Organization">
                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400">{{ __('Manufacturer') }}:
                            <span itemprop="name" class="text-gray-700 dark:text-gray-200">
                                {{ $brand->name }}</span>
                        </div>
                        <div itemprop="location" itemscope itemtype="http://schema.org/Country"
                            class="text-sm sm:text-base text-gray-500 dark:text-gray-400">{{ __('Country') }}:
                            <span itemprop="name" class="text-gray-700 dark:text-gray-200">
                                {{ $brand->country }}</span>
                        </div>
                    </div>

                    <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400" itemprop="additionalProperty"
                        itemscope itemtype="http://schema.org/PropertyValue">
                        <span itemprop="name">{{ __('Power (kW/h)') }}</span>:
                        <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                            {{ $model->max_power }}</span>
                        <meta itemprop="unitText" content="kW/h" />
                    </div>

                    <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400" itemprop="additionalProperty"
                        itemscope itemtype="http://schema.org/PropertyValue">
                        <span itemprop="name">{{ __('Phases') }}</span>:
                        <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                            {{ $model->phases }}</span>
                    </div>

                    <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400" itemprop="additionalProperty"
                        itemscope itemtype="http://schema.org/PropertyValue">
                        <span itemprop="name">{{ __('Gas type') }}</span>:
                        <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                            {{ __('Natural') }}</span>
                    </div>

                    <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400" itemprop="additionalProperty"
                        itemscope itemtype="http://schema.org/PropertyValue">
                        <span itemprop="name">{{ __('Fuel consumption (m³/h)') }}</span>:
                        <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                            {{ $model->fuel_consumption }}</span>
                    </div>

                    <meta itemprop="description"
                        content="ГПУ от производителя {{ $brand->name }} модели {{ $model->name }}" />
                    {{-- <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>

                        <p class="text-sm sm:text-base text-gray-950">{{ $model->description }}</p>
                    </div> --}}

                    <div itemprop="hasPart" itemscope itemtype="https://schema.org/Product"
                        class="mt-6 sm:mt-8 md:mt-10">
                        <h3 itemprop="name" class="mb-1 sm:mb-2 sm:text-lg text-gray-800 dark:text-gray-200">
                            {{ __('Engine') }}
                        </h3>

                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                            <span>{{ __('Model') }}</span>:
                            <span itemprop="model" class="text-gray-700 dark:text-gray-200">
                                {{ $model->gpuEngineModel->name }}</span>
                        </div>

                        <div itemprop="manufacturer" itemscope itemtype="http://schema.org/Organization">
                            <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                                {{ __('Manufacturer') }}:
                                <span itemprop="name" class="text-gray-700 dark:text-gray-200">
                                    {{ $model->gpuEngineModel->gpuEngineBrand->name }}</span>
                            </div>
                            <div itemprop="location" itemscope itemtype="http://schema.org/Country"
                                class="text-sm sm:text-base text-gray-500 dark:text-gray-400">{{ __('Country') }}:
                                <span itemprop="name" class="text-gray-700 dark:text-gray-200">
                                    {{ $model->gpuEngineModel->gpuEngineBrand->country }}</span>
                            </div>
                        </div>

                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400"
                            itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                            <span itemprop="name">{{ __('Volume (l)') }}</span>:
                            <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                                {{ $model->gpuEngineModel->volume }}</span>
                            <meta itemprop="unitCode" content="LTR" />
                        </div>

                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400"
                            itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                            <span itemprop="name">{{ __('Cylinders') }}</span>:
                            <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                                {{ $model->gpuEngineModel->cylinders }}</span>
                        </div>

                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400"
                            itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                            <span itemprop="name">{{ __('RPM') }}</span>:
                            <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                                {{ $model->gpuEngineModel->rpm }}</span>
                        </div>

                        <div class="text-sm sm:text-base text-gray-500 dark:text-gray-400"
                            itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                            <span itemprop="name">{{ __('Cooling type') }}</span>:
                            <span itemprop="value" class="text-gray-700 dark:text-gray-200">
                                {{ __('Liquid') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 md:mt-10">
                        <h3 class="mb-1 sm:mb-2 sm:text-lg text-gray-800 dark:text-gray-200">
                            {{ __('Dimensions') }}
                        </h3>

                        <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"
                            class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                            <span itemprop="name">{{ __('Length (mm)') }}</span>:
                            <span itemprop="value"
                                class="text-gray-700 dark:text-gray-200">{{ $model->length }}</span>
                        </div>
                        <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"
                            class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                            <span itemprop="name">{{ __('Width (mm)') }}</span>:
                            <span itemprop="value"
                                class="text-gray-700 dark:text-gray-200">{{ $model->width }}</span>
                        </div>
                        <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"
                            class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                            <span itemprop="name">{{ __('Height (mm)') }}</span>:
                            <span itemprop="value"
                                class="text-gray-700 dark:text-gray-200">{{ $model->height }}</span>
                        </div>
                        <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue"
                            class="text-sm sm:text-base text-gray-500 dark:text-gray-400">
                            <span itemprop="name">{{ __('Weight (kg)') }}</span>:
                            <span itemprop="value"
                                class="text-gray-700 dark:text-gray-200">{{ $model->weight }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
