<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    @if ($attributes->has('header'))
        <x-slot name="header">
            <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                {{ $attributes->get('header') }}
            </h1>
        </x-slot>
    @endif

    <div class="max-w-10xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="lg:grid grid-cols-12 gap-4 items-start relative" x-data="{ isXL: window.matchMedia('(min-width: 1024px)').matches }" x-init="if (!isXL) window.initLazyComponent($data, '1024px')">
            <template x-if="isXL">
                <div class="hidden lg:flex flex-col lg:col-span-3 xl:col-span-2 gap-4">
                    @include('home.components.categories')
                    @include('insight.components.popular-article')
                    @include('home.components.top-channels')
                </div>
            </template>

            <div class="lg:col-span-6 xl:col-span-7">
                {{ $slot }}
            </div>

            <template x-if="isXL">
                <div class="hidden lg:flex flex-col lg:col-span-3 gap-4">
                    @include('home.components.asic-models')
                    <x-ai-kodex targetWidth="1024" />
                    @include('home.components.asic-brands')
                    @include('home.components.last-forum-questions')

                    @if (isset($sidebar))
                        {{ $sidebar }}
                    @endif
                </div>
            </template>
        </div>
    </div>
</x-app-layout>
