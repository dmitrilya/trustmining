@foreach ($videos as $video)
    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <meta itemprop="position" content="{{ $loop->iteration }}" />

        @include('insight.video.components.card')
    </div>
@endforeach
