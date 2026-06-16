<meta itemprop="name" content="{{ $selVersion['b'] . ' ' . $selModel['n'] }}" />
<meta itemprop="description"
    content="ASIC майнер от производителя {{ $selVersion['b'] }} модели {{ $selModel['n'] }} на {{ $selVersion['h'] }} {{ $selVersion['m'] }}" />
<div itemprop="brand" itemscope itemtype="http://schema.org/Brand">
    <meta itemprop="name" content="{{ $selVersion['b'] }}" />
</div>
<div itemprop="model" itemscope itemtype="http://schema.org/ProductModel">
    <meta itemprop="name" content="{{ $selModel['n'] }}">
</div>
@if ($selVersion['r'])
    <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <meta itemprop="ratingValue" content="{{ $selVersion['ra'] }}" />
        <meta itemprop="worstRating" content="1">
        <meta itemprop="bestRating" content="5" />
        <meta itemprop="reviewCount" content="{{ $selVersion['r'] }}" />
        <link itemprop="url"
            href="{{ route('database.asic-miners.reviews', [
                'asicBrand' => $selVersion['bs'],
                'asicModel' => $selVersion['ns'],
            ]) }}" />
    </div>
@endif
<div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
    <meta itemprop="name" content="{{ __('Algorithm') }}">
    <meta itemprop="value" content=" {{ $algorithm }}">
</div>
<div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
    <meta itemprop="valueReference" content="{{ __('Power') }}" />
    <meta itemprop="unitCode" content="W" />
    <meta itemprop="value" content="{{ $selVersion['e'] * $selVersion['h'] }}" />
</div>
<div itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
    <meta itemprop="name" content="{{ __('Average price') }}">
    <meta itemprop="value" content="{{ $selVersion['p'] ? $selVersion['p'] : __('No data') }}">
</div>
@if (count($selVersion['ps']))
    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('day') }}" />
        <meta itemprop="unitCode" content="RUB" />
        <meta itemprop="value" content="{{ round($selVersion['ps'][0]['p'] / $rub, 2) }}" />
    </div>
    <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
        <meta itemprop="valueReference" content="{{ __('Income per') }} {{ __('month') }}" />
        <meta itemprop="unitCode" content="RUB" />
        <meta itemprop="value" content="{{ round(($selVersion['ps'][0]['p'] / $rub) * 30, 2) }}" />
    </div>
    @if ($selVersion['p'])
        <div itemprop="hasMeasurement" itemscope itemtype="http://schema.org/QuantitativeValue">
            <meta itemprop="valueReference" content="{{ __('Payback') }}" />
            <meta itemprop="unitCode" content="DAY" />
            <meta itemprop="value"
                content="{{ $selVersion['ps'][0]['p'] -
                    ($selVersion['e'] * $selVersion['h'] * 5 * $rub * 24) / 1000 >
                0
                    ? round(
                        $selVersion['p'] /
                            ($selVersion['ps'][0]['p'] -
                                ($selVersion['e'] * $selVersion['h'] * 5 * $rub * 24) / 1000),
                    )
                    : 0 }}" />
        </div>
    @endif
@endif

@if ($selVersion['p'])
    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
        <meta itemprop="offerCount" content="{{ $selVersion['ac'] }}" />
        <meta itemprop="lowPrice" content="{{ $selVersion['p'] }}" />
        <meta itemprop="priceCurrency"
            content="USD" />
        <link itemprop="url"
            href="{{ route('ads', ['adCategory' => 'miners', 'model' => $selVersion['m']]) }}" />
    </div>
@else
    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
        <meta itemprop="offerCount" content="0" />
        <meta itemprop="lowPrice" content="0" />
        <meta itemprop="priceCurrency" content="RUB" />
        <link itemprop="url"
            href="{{ route('ads', ['adCategory' => 'miners', 'model' => $selVersion['m']]) }}" />
    </div>
@endif
