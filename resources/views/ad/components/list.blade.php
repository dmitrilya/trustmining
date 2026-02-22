@foreach ($ads as $ad)
    @continue(!$owner && ($ad->moderation || $ad->hidden))

    @if (isset($shop))
        <template x-if="!ad_category_id || {{ $ad->ad_category_id }} == ad_category_id">
            @include('ad.components.card')
        </template>
    @else
        @include('ad.components.card')
    @endif
@endforeach
