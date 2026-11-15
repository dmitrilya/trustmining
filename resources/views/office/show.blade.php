<x-app-layout :title="__('meta.office.show.title', ['name' => $office->user->name, 'city' => $office->cityWhere])" :description="__('meta.office.show.description', ['name' => $office->user->name, 'city' => $office->cityWhere])">
    <x-slot name="header">
        <div class="flex items-center">
            <x-buttons.back-link :href="route('company', ['user' => $office->user->slug])"></x-buttons.back-link>

            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight ml-3">
                {{ __('meta.office.show.header', ['name' => $office->user->name]) }}
            </h1>
        </div>
    </x-slot>

    @php
        $auth = Auth::user();
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @if (isset($moderation))
            @include('moderation.components.buttons')

            @include('office.components.office', [
                'isModeration' => true,
                'images' => ['changed' => isset($moderation->data['images']), 'data' => $moderation->data['images'] ?? $office->images],
                'address' => ['changed' => isset($moderation->data['address']), 'data' => $moderation->data['address'] ?? $office->address],
                'peculiarities' => [
                    'changed' => isset($moderation->data['peculiarities']),
                    'data' => $moderation->data['peculiarities'] ?? $office->peculiarities,
                ],
                'video' => ['changed' => isset($moderation->data['video']), 'data' => $moderation->data['video'] ?? $office->video],
            ])
        @endif

        @include('office.components.office', [
            'isModeration' => false,
            'images' => ['changed' => false, 'data' => $office->images],
            'address' => ['changed' => false, 'data' => $office->address],
            'peculiarities' => ['changed' => false, 'data' => $office->peculiarities],
            'video' => ['changed' => false, 'data' => $office->video],
        ])
    </div>
</x-app-layout>
