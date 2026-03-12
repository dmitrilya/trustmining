@php
    $types = [
        ['name' => 'Blog article', 'slug' => 'blog-article'],
        ['name' => 'Article', 'slug' => 'article'],
        ['name' => 'Post', 'slug' => 'post'],
        ['name' => 'Message', 'slug' => 'message'],
        ['name' => 'Moderation', 'slug' => 'moderation'],
        ['name' => 'Review', 'slug' => 'review'],
        ['name' => 'Track', 'slug' => 'track'],
    ];
@endphp

<x-filter-filter type="checkbox" :name="__('Notification type')" :items="$types" field="notificationable_types"></x-filter-filter>
