<x-app-layout title="Блог: статьи, новости майнинга" description="Новостной блог от TrustMining. Только самые интересные и актуальные статьи">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Blog') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('article.components.list')
    </div>
</x-app-layout>
