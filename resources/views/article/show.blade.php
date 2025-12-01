<x-app-layout title="Блог: {{ $article->title }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ $article->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm dark:shadow-zinc-800 rounded-lg p-2 sm:p-4 md:p-6 mb-6 space-y-4 sm:space-y-6 lg:space-y-8">
            <p class="date-transform text-xxs sm:text-xs font-normal text-gray-500" data-type="date"
                data-date="{{ $article->created_at }}"></p>
            <img src="{{ Storage::url('public/articles/' . $article->id . '.webp') }}" alt=""
                class="rounded-lg w-full">
            <div class="text-xs sm:text-sm text-gray-900 dark:text-gray-100">
                {!! $article->article !!}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 pb-8">
        <div class="grid gap-2 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($articles as $article)
                @php
                    switch ($loop->index) {
                        case 0:
                        case 1:
                            $classes = '!flex';
                            break;
                        case 2:
                            $classes = 'md:!flex';
                            break;
                        case 3:
                            $classes = 'lg:!flex';
                            break;
                        case 4:
                            $classes = 'xl-!flex';
                            break;
                    }
                @endphp

                <div
                    class="hidden {{ $classes }} bg-white shadow-md dark:shadow-zinc-800 overflow-hidden rounded-lg flex-col justify-between">
                    @include('article.components.card')
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
