<x-app-layout :title="'Калькулятор майнинга: рассчитать доходность ' .
    ($rModel ? ($rVersion ? $rModel . ' ' . $rVersion : $rModel) : 'ASIC')" :description="'Рассчитать доход, расход, прибыль и окупаемость ASIC майнера' .
    ($rModel ? ($rVersion ? ' ' . $rModel . ' ' . $rVersion : ' ' . $rModel) : '') .
    ' в удобном калькуляторе майнинга'">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Mining calculator') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div itemscope itemtype="https://schema.org/ViewAction"
            class="bg-white dark:bg-zinc-900 shadow-sm rounded-lg p-2 sm:p-4">
            @php
                $selModel = !$rModel
                    ? ($rVersion
                        ? $models->filter(fn($model) => $model->asicVersions->where('id', $rVersion)->count())->first()
                        : $models->where('name', 'Antminer T21')->first())
                    : $models->where('name', $rModel)->first();
                $selVersion = $rVersion
                    ? $selModel->asicVersions->where('hashrate', $rVersion)->first()
                    : $selModel->asicVersions->first();
                if (!$selVersion) {
                    $selVersion = $selModel->asicVersions->first();
                }
            @endphp

            <meta itemprop="name"
                content="{{ __('Income calculator') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }}" />
            <meta itemprop="description"
                content="{{ __('Calculate revenue, expenses, profit, and ROI for an ASIC miner') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }} {{ __('in a convenient mining calculator') }}" />

            <div itemprop="object" itemscope itemtype="https://schema.org/Product" class="md:grid grid-cols-5"
                x-data="{ currency: 'RUB', tariff: 5, version: {{ $selVersion }}, profitNumber: 0 }">
                <div class="md:p-6 lg:p-9 xl:p-12 col-span-2">
                    <div class="mb-6">
                        <x-input-label for="price" :value="__('Tariff')" />
                        <x-text-input ::value="tariff" @input="tariff = $el.value" id="price" name="price"
                            min="0" max="10" type="number" step="0.01" />
                    </div>

                    <meta itemprop="name" content="{{ $selModel->asicBrand->name . ' ' . $selModel->name }}" />
                    <meta itemprop="description"
                        content="ASIC майнер от производителя {{ $selModel->asicBrand->name }} модели {{ $selModel->name }} на {{ $selVersion->hashrate }} {{ $selVersion->measurement }}" />
                    <div itemprop="brand" itemscope itemtype="http://schema.org/Brand">
                        <meta itemprop="name" content="{{ $selModel->asicBrand->name }}" />
                    </div>
                    <div itemprop="model" itemscope itemtype="http://schema.org/ProductModel">
                        <meta itemprop="name" content="{{ $selModel->name }}">
                    </div>
                    @if ($selVersion->reviews_count)
                        <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
                            <meta itemprop="ratingValue" content="{{ $selVersion->reviews_avg }}" />
                            <meta itemprop="worstRating" content="1">
                            <meta itemprop="bestRating" content="5" />
                            <meta itemprop="reviewCount" content="{{ $selVersion->reviews_count }}" />
                            <link itemprop="url"
                                href="{{ route('database.reviews', [
                                    'asicBrand' => strtolower(str_replace(' ', '_', $selVersion->brand_name)),
                                    'asicModel' => strtolower(str_replace(' ', '_', $selVersion->model_name)),
                                ]) }}" />
                        </div>
                    @endif
                    <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                        <meta itemprop="name" content="{{ __('Algorithm') }}">
                        <meta itemprop="value" content=" {{ $selVersion->algorithm }}">
                    </div>
                    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
                        <meta itemprop="valueReference" content="{{ __('Power') }}" />
                        <meta itemprop="unitCode" content="W" />
                        <meta itemprop="value" content="{{ $selVersion->efficiency * $selVersion->hashrate }}" />
                    </div>
                    <div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
                        <meta itemprop="name" content="{{ __('Average price') }}">
                        <meta itemprop="value" content="{{ $selVersion->price ? $selVersion->price : __('No data') }}">
                    </div>
                    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
                        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('day') }}" />
                        <meta itemprop="unitCode" content="RUB" />
                        <meta itemprop="value" content="{{ round($selVersion->profits[0]['profit'] / $rub, 2) }}" />
                    </div>
                    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
                        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('month') }}" />
                        <meta itemprop="unitCode" content="RUB" />
                        <meta itemprop="value"
                            content="{{ round(($selVersion->profits[0]['profit'] / $rub) * 30, 2) }}" />
                    </div>
                    @if ($selVersion->price)
                        <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
                            <meta itemprop="valueReference" content="{{ __('Payback') }}" />
                            <meta itemprop="unitCode" content="DAY" />
                            <meta itemprop="value"
                                content="{{ $selVersion->profits[0]['profit'] -
                                    ($selVersion->efficiency * $selVersion->hashrate * 5 * $rub * 24) / 1000 >
                                0
                                    ? round(
                                        $selVersion->price /
                                            ($selVersion->profits[0]['profit'] -
                                                ($selVersion->efficiency * $selVersion->hashrate * 5 * $rub * 24) / 1000),
                                    )
                                    : 0 }}" />
                        </div>
                    @endif

                    @php
                        $modelAds = $selModel->asicVersions->pluck('ads')->flatten();
                        $modelAdWithMinPrice = $modelAds->sortBy('price')->first();
                    @endphp

                    @if ($modelAds->count())
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <meta itemprop="offerCount" content="{{ $modelAds->count() }}" />
                            <meta itemprop="lowPrice" content="{{ $modelAdWithMinPrice->price }}" />
                            <meta itemprop="priceCurrency"
                                content="{{ $modelAdWithMinPrice->coin->abbreviation == 'USDT' ? 'USD' : $modelAdWithMinPrice->coin->abbreviation }}" />
                            <link itemprop="url"
                                href="{{ route('ads', ['adCategory' => 'miners', 'model' => $selVersion->model_name]) }}" />
                        </div>
                    @else
                        <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                            <meta itemprop="offerCount" content="0" />
                            <meta itemprop="lowPrice" content="0" />
                            <meta itemprop="priceCurrency" content="RUB" />
                            <link itemprop="url"
                                href="{{ route('ads', ['adCategory' => 'miners', 'model' => $selVersion->model_name]) }}" />
                        </div>
                    @endif

                    @include('ad.miners.selectversion', [
                        'selectedModel' => $selModel,
                        'selectedVersion' => $selVersion,
                    ])

                    <template x-if="version !== null">
                        <div class="mt-6 sm:mt-8 lg:mt-10">
                            <div class="mt-4 sm:mt-6">
                                <h3 class="sr-only">{{ __('Reviews') }}</h3>
                                <div class="flex items-center" x-data="{ momentRating: version.reviews_avg }">
                                    <x-rating></x-rating>

                                    <a :href="'/database/' + version.brand_name + '/' + version.model_name + '/reviews'"
                                        class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                        <span x-text="version.reviews_count"></span>
                                        {{ __('reviews') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-3 sm:mt-4 space-y-1 sm:space-y-2">
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Algorithm') }}:
                                    <span class="text-gray-800 dark:text-gray-200 font-bold"
                                        x-text="version.algorithm"></span>
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">{{ __('Power') }}:
                                    <span class="text-gray-800 dark:text-gray-200 font-bold"
                                        x-text="version.efficiency * version.hashrate"></span> W
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Average price') }}: <span
                                        class="text-gray-800 dark:text-gray-200 font-bold"
                                        x-text="version.price ? version.price + ' USDT' : '{{ __('No data') }}'"></span>
                                </div>
                            </div>
                            <template x-if="version.ads.length">
                                <a class="pt-3 sm:pt-4 lg:pt-6" :href="'/ads/miners?model=' + version.model_name">
                                    <x-primary-button
                                        class="text-xxs sm:text-xs">{{ __('Find ads') }}</x-primary-button>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
                <div
                    class="mt-6 md:mt-0 md:p-6 lg:p-9 xl:p-12 md:border-l border-gray-300 dark:border-zinc-700 col-span-3">
                    <div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
                        <h4 class="text-xs sm:text-sm text-gray-600 dark:text-gray-300">
                            {{ __('Calculation result') }}</h4>
                        <div class="flex cursor-pointer mx-3">
                            <button
                                :class="{
                                    'bg-primary-gradient text-white': currency ==
                                        'RUB',
                                    'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-200': currency ==
                                        'USDT'
                                }"
                                class="p-1 rounded-l border border-r-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                                @click="currency = 'RUB'">RUB</button>
                            <button
                                :class="{
                                    'bg-primary-gradient text-white': currency ==
                                        'USDT',
                                    'bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-200': currency ==
                                        'RUB'
                                }"
                                class="p-1 rounded-r border border-l-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                                @click="currency = 'USDT'">USDT</button>
                        </div>
                    </div>

                    <template x-if="version !== null">
                        <div>
                            <div class="grid grid-cols-4 gap-2 sm:gap-4">
                                <div></div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">{{ __('Income') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">{{ __('Expense') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">{{ __('Profit') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">{{ __('Day') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 10000) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 24 * 10) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 24 / 1000) * 10000) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Month') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 30 * 10000) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 720 * 10) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 30 - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 720 / 1000) * 10000) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400">
                                    {{ __('Year') }}
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 365 * 10000) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round(version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 8760 * 10) / 10000">
                                </div>
                                <div class="text-xxs xs:text-xs text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="Math.round((version.profits[profitNumber].profit / (currency == 'RUB' ? {{ $rub }} : 1) * 365 - version.efficiency * version.hashrate * tariff * (currency == 'USDT' ? {{ $rub }} : 1) * 8760 / 1000) * 10000) / 10000">
                                </div>
                            </div>

                            <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400 mt-6 sm:mt-7 lg:mt-8">
                                {{ __('Payback') }}:
                                <span class="text-gray-800 dark:text-gray-200 font-bold"
                                    x-text="version.price ? 
                                        version.profits[profitNumber].profit - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 / 1000 > 0 ?
                                        Math.round(version.price / (version.profits[profitNumber].profit - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 / 1000)) + ' {{ __('Days') }}' :
                                        '∞' : '{{ __('No data') }}'"></span>
                            </div>

                            <h4 class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-6 sm:mt-7 lg:mt-8">
                                {{ __('Coins per day') }}</h4>

                            <template x-for="(profit, i) in version.profits" :key="'profit_' + i">
                                <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer"
                                    @click="profitNumber = i">
                                    <div>
                                        <label class="flex items-center">
                                            <input type="radio" name="profitNumber" :value="i"
                                                :checked="profitNumber == i"
                                                class="mr-2 w-3 h-3 sm:w-4 sm:h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-zinc-800 dark:border-zinc-700 cursor-pointer">
                                        </label>
                                    </div>
                                    <template x-for="coin in profit.coins" :key="coin.abbreviation">
                                        <div>
                                            <div class="flex items-center">
                                                <img :src="'/storage/coins/' + coin.abbreviation + '.webp'"
                                                    :alt="coin.name" class="w-3 xs:w-4 sm:w-5 mr-1 xs:mr-2">
                                                <div>
                                                    <div class="text-xxs xs:text-xs text-gray-500"
                                                        x-text="coin.abbreviation">
                                                    </div>
                                                    <div class="text-xxs sm:text-xs text-gray-300" x-text="coin.name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-xxs sm:text-xs text-gray-600 font-bold mt-1"
                                                x-text="Math.round(version.hashrate * coin.profit * 100000000) / 100000000">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
