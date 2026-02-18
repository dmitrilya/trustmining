@php
    $types = [
        ['name' => 'Blog article', 'url_name' => 'blog-article'],
        ['name' => 'Article', 'url_name' => 'article'],
        ['name' => 'Post', 'url_name' => 'post'],
        ['name' => 'Message', 'url_name' => 'message'],
        ['name' => 'Moderation', 'url_name' => 'moderation'],
        ['name' => 'Review', 'url_name' => 'review'],
        ['name' => 'Track', 'url_name' => 'track'],
    ];
@endphp

<x-filter-filter type="checkbox" :name="__('Notification type')" :items="$types" field="notificationable_types"></x-filter-filter>
