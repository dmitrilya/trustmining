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
@if (count($selVersion->profits))
    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('day') }}" />
        <meta itemprop="unitCode" content="RUB" />
        <meta itemprop="value" content="{{ round($selVersion->profits[0]['profit'] / $rub, 2) }}" />
    </div>
    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('month') }}" />
        <meta itemprop="unitCode" content="RUB" />
        <meta itemprop="value" content="{{ round(($selVersion->profits[0]['profit'] / $rub) * 30, 2) }}" />
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
@endif

@php
    $modelAds = $selModel->asicVersions->pluck('ads')->flatten();
    $modelAdWithMinPrice = $modelAds->where('price', '!=', 0)->sortBy('price')->first();
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
