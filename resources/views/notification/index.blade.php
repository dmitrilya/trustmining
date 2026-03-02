<x-app-layout title="Оповещения" description="Посмотрите оповещения на платформе TrustMining">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
                {{ __('Notifications') }}
            </h1>

            <x-header-filters :withoutSort="true"></x-header-filters>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('notification.components.list')
    </div>
</x-app-layout>
