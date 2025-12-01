<x-app-layout title="Оповещения">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('Notifications') }}
            </h2>

            <x-header-filters :withoutSort="true"></x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('notification.components.list')
    </div>
</x-app-layout>
