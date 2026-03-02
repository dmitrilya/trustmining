@php
    $auth = Auth::user();
    $serviceFilter = request()->peculiarities && in_array('Repair service', request()->peculiarities);
    $cryptoexchangerFilter = request()->peculiarities && in_array('Cryptoexchanger', request()->peculiarities);

    if ($serviceFilter) {
        $title = 'Сервисные центры по ремонту майнингового оборудования, точки продаж ASIC майнеров';
        $description = 'Каталог сервисных центров по ремонту ASIC и видеокарт, а также проверенные точки продаж майнингового оборудования. Сравните цены, найдите ближайший сервис и купите оборудование для майнинга с гарантией в вашем городе';
    }
    elseif ($cryptoexchangerFilter) {
        $title = 'Криптообменники, организации по обмену криптовалюты';
        $description = 'Рейтинг проверенных криптообменников и организаций по обмену валют. Сравнивайте курсы, читайте реальные отзывы и выбирайте надежные сервисы для безопасного обмена Bitcoin, USDT и других активов на фиат с минимальной комиссией';
    }
    else {
        $title = 'Офисы майнинговых компаний, точки продаж ASIC майнеров';
        $description = 'Сравните предложения от ведущих поставщиков оборудования для майнинга. Адреса офисов, актуальное наличие ASIC-майнеров и цены в точках продаж. Покупайте оборудование для добычи криптовалют у официальных дилеров с сервисным обслуживанием';
    }
@endphp

<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
                @if ($serviceFilter)
                    {{ __('Repair services') }}
                @elseif ($cryptoexchangerFilter)
                    {{ __('Cryptoexchangers') }}
                @else
                    {{ __('Offices') }}
                @endif
            </h1>

            <x-header-filters withoutSort="true" />
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('office.components.list')
    </div>
</x-app-layout>
