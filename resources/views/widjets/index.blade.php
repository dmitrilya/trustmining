<x-app-layout title="Встроить калькулятор майнинга и виджет сложности на сайт — Документация и API | TRUSTMINING"
    description="Добавьте интерактивные инструменты для майнеров на свой ресурс. Настраиваемые блоки характеристик, расчет окупаемости и актуальная сложность сети. Инструкция по использованию iframe-виджетов и кастомизации параметров">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Widjets') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8 space-y-8 lg:space-y-12">
        @include('widjets.calculator')

        @include('widjets.difficulty')
    </div>
</x-app-layout>
