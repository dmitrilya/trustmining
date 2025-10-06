<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $attributes->get('header') }}
        </h2>
    </x-slot>

    <div class="max-w-9xl mx-auto px-2 sm:px-6 lg:px-8 py-8" x-data="{ show: false }">
        <div class="md:grid grid-cols-6 gap-4 xl:gap-6 items-start relative">
            <div :class="{ '-left-full': !show, 'left-2': show }"
                class="absolute top-12 duration-200 md:top-0 bg-gray-100 md:left-0 md:relative md:col-span-2 lg:col-span-1 md:bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-3 sm:p-4 md:p-6">
                @include('layouts.components.metrics-menu')
            </div>

            <div class="md:col-span-4 lg:col-span-5">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>
