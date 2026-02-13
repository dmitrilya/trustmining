<x-app-layout title="Блог: {{ $article->title }}" description="{{ $article->subtitle }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ $article->title }}
        </h1>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="bg-white/60 dark:bg-zinc-900/60 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
            <p class="date-transform text-xxs sm:text-xs text-gray-500" data-type="date"
                data-date="{{ $article->created_at }}"></p>
            <img src="{{ Storage::url('public/articles/' . $article->id . '.webp') }}" alt=""
                class="rounded-lg w-full">
            <div class="text-xs sm:text-sm text-gray-900 dark:text-gray-100">
                {!! $article->article !!}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('article.components.list')
    </div>
</x-app-layout>
