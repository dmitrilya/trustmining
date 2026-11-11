<x-app-layout :title="__('meta.hosting.shop.title', ['name' => $user->name])" :description="__('meta.hosting.shop.description', ['name' => $user->name])" itemtype="https://schema.org/ProfilePage" :itemname="__('Company') . ' ' . $user->name">
    <x-slot name="og">
        <meta property="og:title" content="{{ $user->company && !$user->company->moderation ? __('Company') : __('Seller') }} {{ $user->name }}">
        <meta property="og:description" content="{{ __('meta.hosting.shop.description', ['name' => $user->name]) }}">
        @if ($user->company && !$user->company->moderation)
            <meta property="og:image" content="{{ Storage::disk('public')->url($user->company->logo) }}">
        @endif
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @if ($user->company && !$user->company->moderation)
            @include('shop.components.about')
        @endif

        <div class="grid gap-2 grid-cols-1 xl:grid-cols-2">
            @php
                $auth = Auth::user();
            @endphp

            @include('hosting.components.list')
        </div>
    </div>
</x-app-layout>
