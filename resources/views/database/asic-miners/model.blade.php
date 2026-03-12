<x-app-layout :title='"ASIC {$brand->name} {$model->name} {$selectedVersion->hashrate}{$selectedVersion->measurement} - цена, доходность и характеристики | Купить {$brand->name} {$model->name} | TRUSTMINING"' :description='"ASIC {$brand->name} {$model->name} {$selectedVersion->hashrate}{$selectedVersion->measurement}. Характеристики, энергопотребление, доходность майнинга и окупаемость. Актуальные предложения продавцов и цены. Купить {$model->name} с доставкой по РФ на TRUSTMINING"'
    canonical="{{ route('database.asic-miners.version', [
        'asicBrand' => $brand->slug,
        'asicModel' => $model->slug,
        'asicVersion' => $selectedVersion->hashrate . $selectedVersion->measurement,
    ]) }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
            <x-breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $brand->slug])" :name="$brand->name" />
            @if (request()->routeIs('database.asic-miners.model'))
                <x-breadcrumb position="3" :name="$model->name" />
            @else
                <x-breadcrumb position="3" :href="route('database.asic-miners.model', [
                    'asicBrand' => $brand->slug,
                    'asicModel' => $model->slug,
                ])" :name="$model->name" />
                <x-breadcrumb position="4" :name="$selectedVersion->hashrate . $selectedVersion->measurement" />
            @endif
        </x-breadcrumbs>

        <div itemscope itemtype="https://schema.org/Product"
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 lg:p-14">
            {{-- <div class="mb-6 md:mb-12">
                @include('database.components.model-images')
            </div> --}}

            <div class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
                <div class="md:col-span-2 md:border-r border-slate-300 dark:border-slate-700 md:pr-8">
                    <meta itemprop="brand" content="{{ $brand->name }}" />
                    <h1 itemprop="name"
                        class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>

                    @php
                        $hasTariff = ($user = Auth::user()) && $user->tariff;
                        $momentRating = $model->moderatedReviews->count() ? $model->moderatedReviews->avg('rating') : 0;
                        $modelAds = $versions->pluck('ads')->flatten();
                        $modelAdWithMinPrice = $modelAds->where('price', '!=', 0)->sortBy('price')->first();
                        $reviewsCount = $model->moderatedReviews->count();
                    @endphp

                    <div class="md:col-span-2 md:col-start-1 mt-4 md:mt-8" x-data="{ selectedTab: {{ array_search($selectedVersion->id, $versions->pluck('id')->toArray()) }} }">
                        <div
                            class="text-xxs xs:text-xs{{ $versions->count() > 12 ? '' : ' sm:text-sm ' }}text-center text-slate-600 border-b border-slate-300 dark:text-slate-300 dark:border-slate-800">
                            <ul class="flex flex-wrap -mb-px">
                                @foreach ($versions as $i => $version)
                                    <li class="mr-1 sm:mr-2">
                                        <button class="inline-block p-1 xs:p-2 sm:p-3{{ $versions->count() > 12 ? '' : ' lg:p-4 ' }}border-b-2 rounded-t-lg"
                                            @click="selectedTab = {{ $i }}"
                                            :class="{
                                                'border-transparent hover:text-slate-600 hover:border-slate-300 dark:hover:text-slate-300': {{ $i }} !=
                                                    selectedTab,
                                                'text-indigo-600 border-indigo-600 active dark:text-indigo-600 dark:border-indigo-600': {{ $i }} ==
                                                    selectedTab
                                            }">
                                            {{ $version->hashrate }}{{ $version->measurement }}
                                        </button>
                                    </li>

                                    <a href="{{ route('database.asic-miners.version', [
                                        'asicBrand' => $brand->slug,
                                        'asicModel' => $model->slug,
                                        'asicVersion' => $selectedVersion->hashrate . $selectedVersion->measurement,
                                    ]) }}"
                                        aria-label="{{ $model->name . ' ' . $selectedVersion->hashrate . $selectedVersion->measurement }}"></a>
                                @endforeach
                            </ul>
                        </div>

                        @foreach ($versions as $i => $version)
                            <div x-show="selectedTab == {{ $i }}" itemprop="model" itemscope
                                itemtype="http://schema.org/ProductModel"
                                style="display: {{ $version->id == $selectedVersion->id ? 'block' : 'none' }}">
                                @php
                                    $minPrice = $version->ads->where('price', '!=', 0)->first();
                                @endphp

                                <meta itemprop="name"
                                    content="{{ $model->name . ' ' . $version->hashrate . $version->measurement }}" />

                                <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-4 md:my-6">
                                    <x-characteristic name="Hashrate" :value="$version->hashrate" itemprop="hasMeasurement"
                                        :unit="[
                                            'prop' => 'unitText',
                                            'content' => $version->measurement . '/s',
                                        ]" />
                                    <x-characteristic name="Efficiency" :value="$version->efficiency" itemprop="hasMeasurement"
                                        :unit="[
                                            'prop' => 'unitText',
                                            'content' => 'j/' . $version->measurement,
                                        ]" />
                                    <x-characteristic name="Power" :value="$version->efficiency * $version->hashrate" itemprop="hasMeasurement"
                                        :unit="['prop' => 'unitCode', 'content' => 'W']" />
                                    @if ($minPrice)
                                        <x-characteristic name="The best price" :value="$minPrice->price . ' ' . $minPrice->coin->abbreviation" />
                                    @endif
                                </x-characteristics>

                                @if ($minPrice)
                                    <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <meta itemprop="bestPrice" content="{{ $minPrice->price }}" />
                                        <meta itemprop="priceCurrency"
                                            content="{{ $minPrice->coin->abbreviation == 'USDT' ? 'USD' : $modelAdWithMinPrice->coin->abbreviation }}" />
                                    </div>

                                    @include('ad.components.payback_info', [
                                        'profit' => $version->data->profits[0]['profit'],
                                        'expense' =>
                                            (($version->hashrate * $version->efficiency * 24) / 1000) * $rub,
                                        'tariff' => 5,
                                        'price' => $minPrice->price * $minPrice->coin->rate,
                                    ])

                                    <div class="xs:flex mt-6 md:mt-8 ">
                                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                            <meta itemprop="lowPrice" content="{{ $minPrice->price }}" />
                                            <meta itemprop="priceCurrency"
                                                content="{{ $minPrice->coin->abbreviation == 'USDT' ? 'USD' : $modelAdWithMinPrice->coin->abbreviation }}" />
                                            <meta itemprop="url"
                                                content="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug, 'asic_version_id' => $version->id]) }}" />
                                        </div>

                                        <div itemprop="potentialAction" itemscope
                                            itemtype="https://schema.org/ViewAction" class="mt-2 xs:mt-0">
                                            <meta itemprop="name"
                                                content="{{ __('Income calculator') }} {{ $brand->name }} {{ $model->name }} {{ $version->hashrate }}{{ $version->measurement }}" />

                                            <div itemprop="target" itemscope itemtype="https://schema.org/EntryPoint">
                                                <a itemprop="urlTemplate" class="block w-full xs:w-fit"
                                                    href="{{ route('calculator.modelver', ['asicModel' => $model->slug, 'asicVersion' => $version->hashrate]) }}">
                                                    <x-secondary-button
                                                        class="bg-secondary-gradient dark:text-slate-800 w-full justify-center">{{ __('Income calculator') }}</x-secondary-button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    @include('ad.components.payback_info', [
                                        'profit' => $version->data->profits[0]['profit'],
                                        'expense' =>
                                            (($version->hashrate * $version->efficiency * 24) / 1000) * $rub,
                                        'tariff' => 5,
                                        'price' => 0,
                                    ])

                                    <div class="flex mt-6 md:mt-8">
                                        <div itemprop="potentialAction" itemscope
                                            itemtype="https://schema.org/ViewAction">
                                            <meta itemprop="name"
                                                content="{{ __('Income calculator') }} {{ $brand->name }} {{ $model->name }} {{ $version->hashrate }}{{ $version->measurement }}" />

                                            <div itemprop="target" itemscope itemtype="https://schema.org/EntryPoint">
                                                <a itemprop="urlTemplate" class="block w-fit"
                                                    href="{{ route('calculator.modelver', ['asicModel' => $model->slug, 'asicVersion' => $version->hashrate]) }}">
                                                    <x-secondary-button
                                                        class="bg-secondary-gradient dark:text-slate-800">{{ __('Income calculator') }}</x-secondary-button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <h3 class="text-sm text-slate-950 dark:text-slate-100 mt-8 mb-3">
                                    {{ __('Coins') }}
                                </h3>

                                <div class="grid gap-2 grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                                    @foreach ($algorithm->coins->where('profit', '>', 0) as $coin)
                                        <div class="flex items-center">
                                            <img alt="{{ $coin->name }}" class="w-6 sm:w-7 mr-2"
                                                src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}" />
                                            <div>
                                                <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-500">
                                                    {{ $coin->abbreviation }}
                                                </div>
                                                <div class="text-xxs sm:text-xs text-slate-400 dark:text-slate-300">
                                                    {{ $coin->name }}
                                                </div>
                                                <div
                                                    class="mt-1 text-xxs xs:text-xs text-sm text-slate-600 dark:text-slate-400">
                                                    {{ number_format($version->hashrate * $coin->profit, 8) }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 md:mt-0">
                    <h2 class="sr-only">Информация</h2>

                    <x-characteristics>
                        <x-characteristic name="Manufacturer" :value="$brand->name" itemprop="additionalProperty" />
                        <x-characteristic name="Algorithm" :value="$algorithm->name" itemprop="additionalProperty" />
                        <x-characteristic name="Cooling" :value="$model->characteristics['Cooling']" itemprop="additionalProperty" />
                        <x-characteristic name="Release date" :value="$model->release->locale('ru')->translatedFormat('F Y')" />
                        <meta itemprop="releaseDate" content="{{ $model->release->toIso8601String() }}">
                    </x-characteristics>

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
                                    href="{{ route('database.asic-miners.reviews', [
                                        'asicBrand' => $brand->slug,
                                        'asicModel' => $model->slug,
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

                                <a href="{{ route('database.asic-miners.reviews', [
                                    'asicBrand' => $brand->slug,
                                    'asicModel' => $model->slug,
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
                                    content="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />

                                <x-primary-button class="w-full h-full"
                                    @click="document.querySelector('#infinite-loader').previousElementSibling.scrollIntoView({behavior: 'smooth'})">{{ __('Buy') }}</x-primary-button>
                            </div>
                        @else
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <meta itemprop="lowPrice" content="0" />
                                <meta itemprop="priceCurrency" content="RUB" />
                                <link itemprop="url"
                                    href="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />
                            </div>

                            <x-primary-button
                                class="w-full h-full cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                        @endif

                        <a href="{{ route('ads', ['adCategory' => 'miners']) }}">
                            <x-secondary-button class="w-full">{{ __('View all ads') }}</x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-4 sm:mt-8">
                @include('database.asic-miners.description')
            </div>
        </div>

        <section class="mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Offers') }}
                    {{ request()->routeIs('database.asic-miners.model') ? $model->name : $model->name . ' ' . $selectedVersion->hashrate . $selectedVersion->measurement }}
                </h2>
            </div>

            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader"
                x-data="{}" x-init="new InfiniteLoader({ endpoint: '{{ request()->routeIs('database.asic-miners.model')
                    ? route('database.asic-miners.model.get-ads', ['asicBrand' => $brand->slug, 'asicModel' => $model->slug])
                    : route('database.asic-miners.version.get-ads', [
                        'asicBrand' => $brand->slug,
                        'asicModel' => $model->slug,
                        'asicVersion' => $selectedVersion->hashrate . $selectedVersion->measurement,
                    ]) }}', page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }} });">
                @include('ad.components.list', ['owner' => false])
            </div>
        </section>
    </div>
</x-app-layout>
