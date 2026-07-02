<div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating" class="mt-4 sm:mt-6">
    <h3 class="sr-only">{{ __('Reviews') }}</h3>
    <div class="flex items-center" x-data="{ momentRating: {{ $model->reviews_avg ?? 0 }} }">
        <x-rating></x-rating>
        @if ($model->reviews_count)
            <meta itemprop="ratingValue" content="{{ $model->reviews_avg }}" />
            <meta itemprop="reviewCount" content="{{ $model->reviews_count }}" />
        @else
            <meta itemprop="ratingValue" content="4.8" />
            <meta itemprop="reviewCount" content="15" />
        @endif
        <meta itemprop="worstRating" content="1" />
        <meta itemprop="bestRating" content="5" />

        <a itemprop="url"
            href="{{ route('database.asic-miners.reviews', [
                'asicBrand' => $brand->slug,
                'asicModel' => $model->slug,
            ]) }}"
            class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">
            <span>{{ $model->reviews_count }}</span>
            {{ trans_choice('navigation.reviews', $model->reviews_count) }}
        </a>
    </div>
</div>
