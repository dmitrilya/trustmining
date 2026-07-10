<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ $attributes->get('header') }}
        </h1>
    </x-slot>

    <div class="max-w-9xl mx-auto p-2 sm:p-6 lg:p-8" x-data="{ show: false }">
        <div class="lg:grid grid-cols-9 gap-4 items-start relative">
            <grid class="lg:col-span-3 xl:col-span-2 grid grid-cols-1 gap-4">
                @include('layouts.components.metrics-menu')
                <x-ai-kodex targetWidth="1024" />
            </grid>
                
            <div class="lg:col-span-6 xl:col-span-7">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
