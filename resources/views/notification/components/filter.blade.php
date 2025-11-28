@php
    $types = [
        ['name' => 'Article', 'url_name' => 'App\Models\Blog\Article'],
        ['name' => 'Guide', 'url_name' => 'App\Models\Blog\Guide'],
        ['name' => 'Message', 'url_name' => 'App\Models\Chat\Message'],
        ['name' => 'Moderation', 'url_name' => 'App\Models\Morph\Moderation'],
        ['name' => 'Review', 'url_name' => 'App\Models\Morph\Review'],
        ['name' => 'Track', 'url_name' => 'App\Models\Ad\Track'],
    ];
@endphp

<x-filter-filter type="checkbox" :name="__('Notification type')" :items="$types" field="notificationable_types"></x-filter-filter>
