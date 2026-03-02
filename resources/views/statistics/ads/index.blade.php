<x-app-layout title="Статистика объявлений" description="Отчеты эффективности объявлений">
    @vite(['resources/js/graph.js'])

    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Ad performance') }}
        </h1>
    </x-slot>

    <div class="max-w-9xl mx-auto px-2 py-4 sm:p-6 lg:p-8" x-data="adsStatisticsData">
        @include('statistics.components.period')

        @include('statistics.ads.components.summary')

        @include('statistics.ads.components.list')
    </div>
</x-app-layout>
