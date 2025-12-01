@php
    $auth = Auth::user();
    $serviceFilter = request()->peculiarities && in_array('Repair service', request()->peculiarities);
    $cryptoexchangerFilter = request()->peculiarities && in_array('Cryptoexchanger', request()->peculiarities);

    if ($serviceFilter) $title = 'Сервисные центры по ремонту майнингового оборудования, точки продаж ASIC майнеров';
    elseif ($cryptoexchangerFilter) $title = 'Криптообменники, организации по обмену криптовалюты';
    else $title = 'Офисы майнинговых компаний , точки продаж ASIC майнеров'
@endphp

<x-app-layout :title="$title">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
                @if ($serviceFilter)
                    {{ __('Repair services') }}
                @elseif ($cryptoexchangerFilter)
                    {{ __('Cryptoexchangers') }}
                @else
                    {{ __('Offices') }}
                @endif
            </h2>

            <x-header-filters withoutSort="true" />
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('office.components.list')
    </div>
</x-app-layout>
