<x-app-layout :title='"ГПЭС {$brand->name} {$model->name} {$model->max_power} кВт/ч - цена, доходность и характеристики | Купить {$brand->name} {$model->name} | TRUSTMINING"' :description='"Газопоршневая установка {$brand->name} {$model->name} {$model->max_power} кВт/ч. Характеристики, отзывы, актуальные предложения продавцов и цены. Купить {$model->name} с доставкой по РФ на TRUSTMINING"'>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" :href="route('database.gas-gensets')" :name="__('Gas gensets')" />
            <x-breadcrumb position="2" :href="route('database.gas-gensets.brand', ['gpuBrand' => $brand->slug])" :name="$brand->name" />
            <x-breadcrumb position="3" :name="$model->name" />
        </x-breadcrumbs>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 lg:p-14">
            <div class="mb-6 md:mb-12">
                @include('database.components.gpu-model-images')
            </div>

            <div itemscope itemtype="https://schema.org/Product"
                class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
                <div class="md:col-span-2 md:border-r border-slate-300 dark:border-slate-700 md:pr-8">
                    <h1 itemprop="name"
                        class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl mb-4 sm:mb-6 lg:mb-8">
                        {{ $model->name }}</h1>

                    @php
                        $hasTariff = ($user = Auth::user()) && $user->tariff;
                        $momentRating = $model->moderatedReviews->count() ? $model->moderatedReviews->avg('rating') : 0;
                        $modelAds = $model->ads;
                        $modelAdWithMinPrice = $modelAds->where('price', '!=', 0)->sortBy('price')->first();
                        $reviewsCount = $model->moderatedReviews->count();
                    @endphp

                    <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-2">
                        <x-characteristic name="Manufacturer" :value="$brand->name" />
                        <x-characteristic name="Country" :value="$brand->country" />
                        <x-characteristic name="Power" :value="$model->max_power" itemprop="additionalProperty"
                            :unit="['prop' => 'unitText', 'content' => 'kW/h']" />
                        <x-characteristic name="Phases" :value="$model->phases" itemprop="additionalProperty" />
                        <x-characteristic name="Gas type" :value="__('Natural')" itemprop="additionalProperty" />
                        <x-characteristic name="Gas consumption" :value="$model->fuel_consumption" itemprop="additionalProperty"
                            :unit="['prop' => 'unitText', 'content' => 'm³/h']" />
                    </x-characteristics>

                    <div itemprop="manufacturer" itemscope itemtype="http://schema.org/Organization">
                        <meta itemprop="name" content="{{ $brand->name }}" />
                        <div itemprop="location" itemscope itemtype="http://schema.org/Country">
                            <meta itemprop="name" content="{{ $brand->country }}" />
                        </div>
                    </div>

                    <meta itemprop="description"
                        content="ГПУ от производителя {{ $brand->name }} модели {{ $model->name }}" />
                    {{-- <div>
                        <h3 class="sr-only">{{ __('Description') }}</h3>

                        <p class="text-sm sm:text-base text-slate-950">{{ $model->description }}</p>
                    </div> --}}

                    <div itemprop="hasPart" itemscope itemtype="https://schema.org/Product" class="mt-4 md:mt-6">
                        <h3 itemprop="name" class="mb-1 sm:mb-2 sm:text-lg text-slate-800 dark:text-slate-200">
                            {{ __('Engine') }}
                        </h3>

                        <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-2">
                            <x-characteristic name="Model" :value="$model->gpuEngineModel->name" />
                            <x-characteristic name="Manufacturer" :value="$model->gpuEngineModel->gpuEngineBrand->name" />
                            <x-characteristic name="Country" :value="$model->gpuEngineModel->gpuEngineBrand->country" />
                            <x-characteristic name="Volume" :value="$model->gpuEngineModel->volume" itemprop="additionalProperty"
                                :unit="['prop' => 'unitCode', 'content' => 'LTR']" />
                            <x-characteristic name="Cylinders" :value="$model->gpuEngineModel->cylinders" itemprop="additionalProperty" />
                            <x-characteristic name="RPM" :value="$model->gpuEngineModel->rpm" itemprop="additionalProperty" />
                            <x-characteristic name="Cooling type" :value="__('Liquid')" itemprop="additionalProperty" />
                        </x-characteristics>

                        <meta itemprop="model" content="{{ $model->gpuEngineModel->name }}" />
                        <div itemprop="manufacturer" itemscope itemtype="http://schema.org/Organization">
                            <meta itemprop="name" content="{{ $model->gpuEngineModel->gpuEngineBrand->name }}" />
                            <div itemprop="location" itemscope itemtype="http://schema.org/Country">
                                <meta itemprop="name"
                                    content="{{ $model->gpuEngineModel->gpuEngineBrand->ncountrye }}" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 md:mt-6">
                        <h3 class="mb-1 sm:mb-2 sm:text-lg text-slate-800 dark:text-slate-200">
                            {{ __('Dimensions') }}
                        </h3>

                        <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-2">
                            <x-characteristic name="Length" :value="$model->length" itemprop="additionalProperty"
                                :unit="['prop' => 'unitCode', 'content' => 'mm']" />
                            <x-characteristic name="Width" :value="$model->width" itemprop="additionalProperty"
                                :unit="['prop' => 'unitCode', 'content' => 'mm']" />
                            <x-characteristic name="Height" :value="$model->height" itemprop="additionalProperty"
                                :unit="['prop' => 'unitCode', 'content' => 'mm']" />
                            <x-characteristic name="Weight" :value="$model->weight" itemprop="additionalProperty"
                                :unit="['prop' => 'unitCode', 'content' => 'mm']" />
                        </x-characteristics>
                    </div>
                </div>

                <div class="mt-4 md:mt-0">
                    <h2 class="sr-only">Информация</h2>

                    <x-characteristics class="mb-4 md:mb-6">
                        @if ($ads->where('price', '!=', 0)->count())
                            @php
                                $minPrice = $ads->where('price', '!=', 0)->sortBy('price')->first();
                            @endphp

                            <x-characteristic name="The best price" :value="$minPrice->price . ' ' . $minPrice->coin" />
                        @endif

                        <x-characteristic name="Offers count" :value="$ads->count()" />
                    </x-characteristics>

                    @if ($reviewsCount)
                        <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                            <h3 class="sr-only">{{ __('Reviews') }}</h3>
                            <div class="flex items-center" x-data="{ momentRating: {{ $momentRating }} }">
                                <x-rating></x-rating>
                                <meta itemprop="ratingValue" content="{{ $momentRating }}" />
                                <meta itemprop="worstRating" content="1" />
                                <meta itemprop="bestRating" content="5" />

                                <a itemprop="url"
                                    href="{{ route('database.gas-gensets.reviews', [
                                        'gpuBrand' => $brand->name,
                                        'gpuModel' => $model->name,
                                    ]) }}"
                                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                    <span itemprop="reviewCount">{{ $reviewsCount }}</span>
                                    {{ __('reviews') }}
                                </a>
                            </div>
                        </div>
                    @else
                        <div>
                            <h3 class="sr-only">{{ __('Reviews') }}</h3>
                            <div class="flex items-center" x-data="{ momentRating: {{ $momentRating }} }">
                                <x-rating></x-rating>

                                <a href="{{ route('database.gas-gensets.reviews', [
                                    'gpuBrand' => $brand->name,
                                    'gpuModel' => $model->name,
                                ]) }}"
                                    class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">{{ $reviewsCount }}
                                    {{ __('reviews') }}
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col gap-2 sm:gap-3 mt-4 sm:mt-6 lg:mt-8">
                        @if ($modelAds->count() && $modelAdWithMinPrice)
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <meta itemprop="lowPrice" content="{{ $modelAdWithMinPrice->price }}" />
                                <meta itemprop="priceCurrency"
                                    content="{{ $modelAdWithMinPrice->coin->abbreviation == 'USDT' ? 'USD' : $modelAdWithMinPrice->coin->abbreviation }}" />
                                <link itemprop="url"
                                    content="{{ route('ads', ['adCategory' => 'gpus', 'gpu_model' => $model->slug]) }}" />

                                <x-primary-button class="w-full h-full"
                                    @click="document.querySelector('#infinite-loader').previousElementSibling.scrollIntoView({behavior: 'smooth'})">{{ __('Buy') }}</x-primary-button>
                            </div>
                        @else
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <meta itemprop="lowPrice" content="0" />
                                <meta itemprop="priceCurrency" content="RUB" />
                                <link itemprop="url"
                                    href="{{ route('ads', ['adCategory' => 'gpus', 'gpu_model' => $model->slug]) }}" />
                            </div>

                            <x-primary-button
                                class="w-full h-full cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                        @endif

                        <a href="{{ route('ads', ['adCategory' => 'gpus']) }}">
                            <x-secondary-button
                                class="w-full text-center">{{ __('View all ads') }}</x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-4 sm:mt-8">
                @include('database.gas-gensets.description')
            </div>
        </div>

        <section class="mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Offers') }} {{ $brand->name }} {{ $model->name }}
                </h2>
            </div>

            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader"
                x-data="{}" x-init="new InfiniteLoader({ endpoint: '{{ route('database.gas-gensets.model.get-ads', ['gpuBrand' => $brand->slug, 'gpuModel' => $model->slug]) }}', page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }} });">
                @include('ad.components.list', ['owner' => false])
            </div>
        </section>
    </div>
</x-app-layout>
