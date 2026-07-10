<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ $attributes->get('header') }}
        </h1>
    </x-slot>

    <div class="max-w-9xl mx-auto p-2 sm:p-6 lg:p-8" x-data="{ show: false }">
        <div class="lg:grid grid-cols-9 gap-4 items-start relative">
            <div :class="{ '-left-full': !show, 'left-2 sm:left-4': show }"
                class="absolute top-16 sm:top-22 duration-300 lg:top-0 bg-slate-100 lg:left-0 lg:relative lg:col-span-3 xl:col-span-2 lg:bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-3 sm:p-4 lg:p-6">
                @include('layouts.components.metrics-menu')
                <x-ai-kodex targetWidth="1024" />
            </div>

            <div class="lg:col-span-6 xl:col-span-7">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
