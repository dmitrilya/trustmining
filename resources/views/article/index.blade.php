<x-app-layout title="Блог: статьи, новости майнинга" description="Новостной блог от TrustMining. Только самые интересные и актуальные статьи">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Blog') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        @include('article.components.list')
    </div>
</x-app-layout>
