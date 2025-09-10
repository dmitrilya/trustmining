@php
    $auth = Auth::user();
    $serviceFilter = request()->peculiarities && in_array('Repair service', request()->peculiarities);
    $title =
        ($serviceFilter ? 'Сервисные центры по ремонту майнингового оборудования' : 'Офисы майнинговых компаний') .
        ', точки продаж ASIC майнеров';
@endphp

<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $serviceFilter ? __('Repair services') : __('Offices') }}
            </h2>

            <x-header-filters withoutSort="true" />
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('office.components.list')
    </div>
</x-app-layout>
