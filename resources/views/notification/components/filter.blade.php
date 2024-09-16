@php
    $types = [
        ['name' => 'Article', 'url_name' => 'App\Models\Article'],
        ['name' => 'Guide', 'url_name' => 'App\Models\Guide'],
        ['name' => 'Message', 'url_name' => 'App\Models\Message'],
        ['name' => 'Moderation', 'url_name' => 'App\Models\Moderation'],
        ['name' => 'Review', 'url_name' => 'App\Models\Review'],
        ['name' => 'Track', 'url_name' => 'App\Models\Track'],
    ];
@endphp

<x-filter-filter :name="__('Notification type')" :items="$types" field="notificationable_types"></x-filter-filter>
