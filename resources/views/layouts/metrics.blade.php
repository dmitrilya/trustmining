<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ $attributes->get('header') }}
        </h1>
    </x-slot>

    <div class="max-w-9xl mx-auto px-2 py-4 sm:p-4 lg:p-6">
        <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
            <a href="{{ route('metrics.network.difficulty', ['coin' => strtolower(request()->route()->coin->name)]) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ request()->routeIs('metrics.network.difficulty') ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('Difficulty') }}
            </a>
            <a href="{{ route('metrics.network.hashrate', ['coin' => strtolower(request()->route()->coin->name)]) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ request()->routeIs('metrics.network.hashrate') ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('Hashrate') }}
            </a>
            <a href="{{ route('metrics.coin.rate', ['coin' => strtolower(request()->route()->coin->name)]) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md {{ request()->routeIs('metrics.coin.rate') ? 'bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200' : 'border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200' }}">
                {{ __('Rate') }}
            </a>
        </div>

        <div class="lg:flex items-start gap-4">
            <div class="flex-1 min-w-0 xl:max-w-[calc(100%-336px)]">
                {{ $slot }}
            </div>

            <div x-data="{ isXL: window.matchMedia('(min-width: 1024px)').matches }" x-init="window.addEventListener('resize', () => isXL = window.matchMedia('(min-width: 1024px)').matches)" class="hidden lg:flex flex-col gap-4 w-xs max-w-xs">
                <template x-if="isXL">
                    <div class="flex flex-col gap-4 w-full">
                        <div
                            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-3">
                            <script src="https://trustmining.ru/build/assets/calculator-widjet.js" data-theme="dark" data-blocks="currency" data-model="antminer-s21+" data-version="235">
                            </script>
                        </div>
                        
                        <x-ai-kodex targetWidth="1024" />
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
