<x-app-layout title="Статистика объявлений" description="Отчеты эффективности объявлений">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ad performance') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-9xl mx-auto px-2 sm:px-6 lg:px-8 py-8" x-data="adsStatisticsData">
        @include('statistics.components.period')

        @include('statistics.ads.components.summary')

        @include('statistics.ads.components.list')
    </div>
</x-app-layout>
