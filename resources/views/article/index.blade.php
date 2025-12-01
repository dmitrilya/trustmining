<x-app-layout title="Блог: статьи, новости майнинга">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Blog') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('article.components.list')
    </div>
</x-app-layout>
