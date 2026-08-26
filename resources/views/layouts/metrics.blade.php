<x-app-layout title="{{ $attributes->get('title') }}" description="{{ $attributes->get('description') }}">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ $attributes->get('header') }}
        </h1>
    </x-slot>

    <div class="max-w-9xl mx-auto px-2 py-4 sm:p-4 lg:p-6">
        <div class="lg:flex items-start gap-4">
            <div class="flex-1 min-w-0 lg:max-w-[calc(100%-336px)]">
                {{ $slot }}
            </div>

            <div x-data="{ isXL: window.matchMedia('(min-width: 1024px)').matches }" x-init="if (!isXL) window.initLazyComponent($data, '1024px')" class="hidden lg:flex flex-col gap-4 w-xs max-w-xs">
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
