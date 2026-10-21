<template x-if="openedAds">
    <div x-show="openAds" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-[1000px]" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 max-h-[1000px]" x-transition:leave-end="opacity-0 max-h-0"
        {{ $attributes->merge(['class' => 'overflow-hidden w-full']) }}>

        <div class="pt-4 pb-4 sm:pb-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2">
                @php
                    $categories = [
                        ['n' => 'Miners', 'r' => route('ads', ['adCategory' => 'miners'])],
                        ['n' => 'Hostings', 'r' => route('hostings')],
                        ['n' => 'Services', 'r' => route('services')],
                        ['n' => 'Legals', 'r' => route('ads', ['adCategory' => 'legals'])],
                        ['n' => 'Containers', 'r' => route('ads', ['adCategory' => 'containers'])],
                        ['n' => 'Noiseboxes', 'r' => route('ads', ['adCategory' => 'noiseboxes'])],
                        ['n' => 'Cryptoboilers', 'r' => route('ads', ['adCategory' => 'cryptoboilers'])],
                        ['n' => 'Water cooling plates', 'r' => route('ads', ['adCategory' => 'water_cooling_plates'])],
                        ['n' => 'GPU', 'r' => route('ads', ['adCategory' => 'gpus'])],
                        ['n' => 'Firmwares', 'r' => route('ads', ['adCategory' => 'firmwares'])],
                        ['n' => 'Monitoring', 'r' => route('ads', ['adCategory' => 'monitorings'])],
                        ['n' => 'Exchangers', 'r' => route('cryptoexchangers')],
                        ['n' => 'Accessories', 'r' => route('ads', ['adCategory' => 'accessories'])],
                        ['n' => 'Hydro racks', 'r' => route('ads', ['adCategory' => 'hydro_racks'])],
                    ];
                @endphp

                @foreach ($categories as $category)
                    <a href="{{ $category['r'] }}"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm lg:text-base tracking-wide text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-emerald-500/50 hover:shadow-md shadow-logo-color transition-all duration-150 bg-white/20 dark:bg-slate-900/20">
                        {{ __($category['n']) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</template>
