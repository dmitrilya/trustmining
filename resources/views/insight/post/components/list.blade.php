@foreach ($posts as $post)
    <div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <meta itemprop="position" content="{{ $loop->iteration }}" />

        @include('insight.post.components.card')
    </div>
@endforeach
