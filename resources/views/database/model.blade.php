<x-app-layout :title="'ASIC майнер ' .
    $brand->name .
    ' ' .
    $model->name .
    (isset($selectedVersion) ? ' ' . $selectedVersion->hashrate . ' ' . $selectedVersion->measurement : '')" :description="'ASIC майнер от производителя ' .
    $brand->name .
    ' модели ' .
    $model->name .
    (isset($selectedVersion) ? ' на ' . $selectedVersion->hashrate . ' ' . $selectedVersion->measurement : '') .
    'Цены, характеристики, расчет доходности, реальные отзывы, фото. Каталог моделей'">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg p-4 md:p-6">
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                    class="flex items-center space-x-1 sm:space-x-2">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="1" />
                        <div class="flex items-center">
                            <a itemprop="item" href="{{ route('database') }}"
                                class="sm:mr-2 text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ __('Catalog of models') }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $brand->name))]) }}"
                                class="sm:mr-2 text-sm font-medium text-gray-800 dark:text-gray-200 hover:text-gray-900 dark:hover:text-gray-100">
                                <span itemprop="name">{{ $brand->name }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-gray-300">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="3" />
                        <a itemprop="item" href="#" aria-current="page"
                            class="font-medium text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <span itemprop="name">{{ $model->name }}</span>
                        </a>
                    </li>
                </ol>
            </nav>

            {{-- @include('database.components.model-images') --}}

            <div itemscope itemtype="https://schema.org/Product"
                class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] mt-6 md:mt-12">
                <div class="md:col-span-2 md:border-r border-gray-200 dark:border-zinc-700 md:pr-8">
                    <meta itemprop="brand" content="{{ $brand->name }}" />
                    <h1 itemprop="name"
                        class="text-xl font-bold tracking-tight text-gray-900 dark:text-gray-200 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>
                </div>

                @php
                    $hasTariff = ($user = \Auth::user()) && $user->tariff;
                    $momentRating = $model->moderatedReviews->count() ? $model->moderatedReviews->avg('rating') : 0;
                    $modelAdsCount = $versions->pluck('ads')->flatten()->count();
                @endphp

                <div class="mt-4 md:row-span-3 md:mt-0 md:pl-6 lg:pl-12 xl:pl-16">
                    <h2 class="sr-only">Информация</h2>

                    <!-- Reviews -->
                    <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"
                        class="mt-4 sm:mt-6">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <div class="flex items-center" x-data="{ momentRating: {{ $momentRating }} }">
                            <x-rating></x-rating>
                            <meta itemprop="ratingValue" content="{{ $momentRating }}" />
                            <meta itemprop="bestRating" content="5" />

                            <a href="{{ route('database.reviews', [
                                'asicBrand' => strtolower(str_replace(' ', '_', $brand->name)),
                                'asicModel' => strtolower(str_replace(' ', '_', $model->name)),
                            ]) }}"
                                class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                <span itemprop="reviewCount">{{ $model->moderatedReviews->count() }}</span>
                                {{ __('reviews') }}
                            </a>
                        </div>
                    </div>

                    @if ($modelAdsCount)
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <meta itemprop="offerCount" content="{{ $modelAdsCount }}" />

                            <a itemprop="url" class="w-max mt-4 sm:mt-6 md:mt-8"
                                href="{{ route('ads', ['adCategory' => 'miners', 'model' => strtolower(str_replace(' ', '_', $model->name))]) }}">
                                <x-primary-button>{{ __('Find ads') }}</x-primary-button>
                            </a>
                        </div>
                    @else
                        <x-primary-button
                            class="mt-4 sm:mt-6 md:mt-8 cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                    @endif
                </div>

                <div
                    class="py-6 sm:py-8 md:col-span-2 md:col-start-1 md:border-r border-gray-200 dark:border-zinc-700 md:pb-16 md:pr-8 md:pt-6">
                    <div class="text-sm text-gray-400" itemprop="additionalProperty" itemscope
                        itemtype="http://schema.org/PropertyValue"><span itemprop="name">{{ __('Algorithm') }}:
                        </span><span class="text-gray-600" itemprop="value">
                            {{ $algorithm->name }}</span></div>

                    <div class="text-sm text-gray-400">{{ __('Release date') }}: <span class="text-gray-600">
                            <time itemprop="releaseDate"
                                datetime="{{ $model->release }}">{{ $model->release->locale('ru')->translatedFormat('F Y') }}</time></span>
                    </div>

                    <div x-data="{ selectedTab: {{ isset($selectedVersion) ? array_search($selectedVersion->id, $versions->pluck('id')->toArray()) : '0' }} }" class="mt-4 md:mt-8">
                        <div
                            class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-zinc-800">
                            <ul class="flex flex-wrap -mb-px">
                                @foreach ($versions as $i => $version)
                                    <li class="me-2">
                                        <a href="#" class="inline-block p-4 border-b-2 rounded-t-lg"
                                            @click="selectedTab = {{ $i }}"
                                            :class="{
                                                'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': {{ $i }} !=
                                                    selectedTab,
                                                'text-indigo-600 border-indigo-600 active dark:text-indigo-600 dark:border-indigo-600': {{ $i }} ==
                                                    selectedTab
                                            }">
                                            {{ $version->hashrate }}{{ $version->measurement }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        @foreach ($versions as $i => $version)
                            <div x-show="selectedTab == {{ $i }}" itemprop="model" itemscope
                                itemtype="http://schema.org/ProductModel">
                                @php
                                    $minPrice = $version->ads->first();
                                @endphp

                                <meta itemprop="name"
                                    content="{{ $model->name . ' ' . $version->hashrate . $version->measurement }}" />

                                <div itemprop="hasMeasurement" itemscope
                                    itemtype="http://schema.org/QuantitativeValue">
                                    <meta itemprop="valueReference" content="Hashrate" />
                                    <meta itemprop="value" content="{{ $version->hashrate }}" />
                                    <meta itemprop="unitText" content="{{ $version->measurement }}/s" />
                                </div>

                                <div itemprop="hasMeasurement" itemscope
                                    itemtype="http://schema.org/QuantitativeValue" class="text-sm text-gray-400 mt-6">
                                    <span itemprop="valueReference">{{ __('Efficiency') }}</span>:
                                    <span itemprop="value" class="text-gray-600">{{ $version->efficiency }}</span>
                                    <span itemprop="unitText">j/{{ $version->measurement }}</span>
                                </div>

                                <div itemprop="hasMeasurement" itemscope
                                    itemtype="http://schema.org/QuantitativeValue"
                                    class="text-sm text-gray-400 mt-1 sm:mt-2"><span
                                        itemprop="valueReference">{{ __('Power') }}</span>:
                                    <span class="text-gray-600"
                                        itemprop="value">{{ $version->efficiency * $version->hashrate }}</span>
                                    <span itemprop="unitCode">W</span>
                                </div>

                                @if ($minPrice)
                                    <div class="text-sm text-gray-400 mt-6">{{ __('The best price') }}:
                                        @if ($hasTariff)
                                            <span itemprop="offers" itemscope itemtype="http://schema.org/Offer"
                                                class="text-gray-600">
                                                {{ $minPrice->price . ' ' . $minPrice->coin->abbreviation }}
                                                <meta itemprop="bestPrice" content="{{ $minPrice->price }}" />
                                                <meta itemprop="priceCurrency"
                                                    content="{{ $minPrice->coin->abbreviation }}" />
                                            </span>
                                        @else
                                            <span class="text-gray-600 blur-sm"
                                                @click.prevent="$dispatch('open-modal', 'need-subscription')">
                                                {{ __('Subscription') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer"
                                        class="mt-6 md:mt-8">
                                        <meta itemprop="offerCount" content="{{ $version->ads->count() }}" />

                                        <a itemprop="url" class="w-max"
                                            href="{{ route('ads', ['adCategory' => 'miners', 'model' => strtolower(str_replace(' ', '_', $model->name)), 'asic_version_id' => $version->id]) }}">
                                            <x-primary-button>{{ __('Buy') }}</x-primary-button>
                                        </a>
                                    </div>
                                @else
                                    <x-primary-button
                                        class="mt-4 sm:mt-6 md:mt-8 cursor-default opacity-60">{{ __('Out of stock') }}</x-primary-button>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <h3 class="text-sm font-medium text-gray-900 mt-8 mb-3">{{ __('Coins') }}</h3>

                    <div class="grid gap-2 grid-cols-3 xs:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                        @foreach ($algorithm->coins as $coin)
                            <div itemprop="isRelatedTo" itemscope itemtype="https://schema.org/Thing"
                                class="flex items-center">
                                <img itemprop="image" alt="{{ $coin->name }}" class="w-5 sm:w-7 mr-2"
                                    src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}">
                                <div>
                                    <div itemprop="alternateName" class="text-xs sm:text-sm text-gray-500 mr-3">
                                        {{ $coin->abbreviation }}
                                    </div>
                                    <div itemprop="name" class="text-xxs sm:text-xs text-gray-300 mr-3">
                                        {{ $coin->name }}
                                    </div>
                                </div>
                                {{-- <div class="text-sm text-gray-600">
                                                {{ number_format($version->hashrate * $coin->profit, 8) }}
                                            </div> --}}
                            </div>
                        @endforeach
                    </div>

                    <div itemprop="isRelatedTo" itemscope itemtype="https://schema.org/WebPage"
                        class="mt-4 xs:mt-6 sm:mt-8">
                        <meta itemprop="name"
                            content="{{ __('Income calculator') }} {{ $brand->name }} {{ $model->name }} {{ $version->hashrate }}{{ $version->measurement }}" />

                        <a itemprop="url" class="block w-fit ml-auto"
                            href="{{ route('calculator.modelver', ['asicModel' => strtolower(str_replace(' ', '_', $model->name)), 'asicVersion' => $version->hashrate]) }}">
                            <x-secondary-button
                                class="bg-secondary-gradient !text-white">{{ __('Income calculator') }}</x-secondary-button>
                        </a>
                    </div>

                    {{-- <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>

                        <p class="text-sm sm:text-base text-gray-900">{{ $model->description }}</p>
                    </div>

                    <div class="mt-6 sm:mt-8 md:mt-10">
                        <h3 class="text-sm font-medium text-gray-900">Характеристики</h3>

                        <ul role="list" class="list-disc space-y-2 pl-4 text-sm mt-4">
                            <li class="text-gray-400">Алгоритм: <span class="text-gray-600">
                                    {{ $model->algorithm->name }}</span></li>
                            <li class="text-gray-400">Размер: <span class="text-gray-600">
                                    {{ $model->width }}см X {{ $model->length }}см X
                                    {{ $model->height }}см</span></li>
                            <li class="text-gray-400">Вес: <span class="text-gray-600">
                                    {{ $model->weight }}кг</span></li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
