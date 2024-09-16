<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row items-center">
            <div class="flex items-center mr-auto w-full max-w-max">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mr-4">
                    {{ $user->name }}
                </h2>
            </div>

            <div class="flex justify-between items-center w-full mt-4 lg:mt-0">
                @include('shop.components.company-menu')

                <x-header-filters></x-header-filters>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        @include('ad.components.list')
    </div>
</x-app-layout>
