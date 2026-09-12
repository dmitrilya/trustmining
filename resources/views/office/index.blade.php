@php
    $auth = Auth::user();
@endphp

<x-app-layout :title="$title" :description="$description">
    @if (!request()->routeIs('company.offices'))
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ $header }}</h1>

                <x-filters.header-filters withoutSort="true" />
            </div>
        </x-slot>
    @endif

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @if (isset($user) && $user->company)
            @include('shop.components.about')
        @endif

        @include('office.components.list')
    </div>
</x-app-layout>
