<x-home-layout :data="$__data" :title="__('meta.wiki.title')" :description="__('meta.wiki.description')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :name="__('meta.wiki.header')" />
    </x-breadcrumbs.breadcrumbs>

    <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-800 dark:text-slate-200 mb-4">
        {{ __('meta.wiki.header') }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <a href="{{ route('database.asic-miners') }}"
            class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-rose-500/10 border border-rose-500/30 shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-2xl">⛏️</span>
                    <h2 class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors">
                        {{ __('ASIC miners') }}
                    </h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __('A comprehensive catalog of mining hardware. Find technical specifications, release dates, and direct manufacturer data.') }}
                </p>
            </div>
            <div class="mt-5 flex items-center text-xs font-bold text-rose-600 dark:text-rose-400 gap-1">
                <span>{{ __('View catalog') }}</span>
                <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
            </div>
        </a>

        <a href="{{ route('coins') }}"
            class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-cyan-500/10 border border-cyan-500/30 shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-2xl">🪙</span>
                    <h2
                        class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        {{ __('Coins') }}
                    </h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __('Track mineable cryptocurrencies. Analyze real-time network block rewards, market capitalization, and daily profitability metrics.') }}
                </p>
            </div>
            <div class="mt-5 flex items-center text-xs font-bold text-cyan-600 dark:text-cyan-400 gap-1">
                <span>{{ __('View coins') }}</span>
                <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
            </div>
        </a>

        <a href="{{ route('algorithms') }}"
            class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-amber-500/10 border border-amber-500/30 shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-2xl">⚙️</span>
                    <h2 class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                        {{ __('Algorithms') }}
                    </h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __('Explore hashing functions and consensus mechanisms. Compare network difficulty scaling and algorithm compatibility across hardware.') }}
                </p>
            </div>
            <div class="mt-5 flex items-center text-xs font-bold text-amber-600 dark:text-amber-400 gap-1">
                <span>{{ __('View algorithms') }}</span>
                <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
            </div>
        </a>

        <a href="{{ route('dictionary') }}"
            class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-indigo-500/10 border border-indigo-500/30 shadow-md transition-all duration-300">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="text-2xl">📖</span>
                    <h2
                        class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-fuchsia-400 transition-colors">
                        {{ __('Crypto dictionary') }}
                    </h2>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ __('Clear and accessible definitions for blockchain and cryptocurrency terminology. Master the core fundamentals of mining ecosystems.') }}
                </p>
            </div>
            <div class="mt-5 flex items-center text-xs font-bold text-indigo-600 dark:text-indigo-400 gap-1">
                <span>{{ __('Open glossary') }}</span>
                <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
            </div>
        </a>
    </div>
</x-home-layout>
