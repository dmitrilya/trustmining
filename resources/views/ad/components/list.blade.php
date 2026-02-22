@foreach ($ads as $ad)
    @continue(!$owner && ($ad->moderation || $ad->hidden))

    @if (isset($shop))
        <template x-if="!ad_category_name || '{{ $ad->ad_category_name }}' == ad_category_name">
            @include('ad.components.card')
        </template>
    @else
        @include('ad.components.card')
    @endif
@endforeach
