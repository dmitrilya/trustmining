<x-filter>@include('insight.post.components.filter')</x-filter>

<fieldset aria-label="Choose a post" class="w-full">
    <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($posts as $post)
            @include('insight.post.components.card')
        @endforeach
    </div>
</fieldset>

<div class="mt-8 sm:mt-12 lg:mt-16">
    {{ $posts->links() }}
</div>

