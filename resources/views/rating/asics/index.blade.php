<x-home-layout :data="$data" :title="__('meta.rating.asics.title', ['year' => now()->year])" :description="__('meta.rating.asics.description')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :name="__('meta.rating.asics.breadcrumb')" />
    </x-breadcrumbs.breadcrumbs>

    <section class="mb-6 sm:mb-8 lg:mb-10">
        <div class="mb-4">
            <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-800 dark:text-slate-200">
                {{ __('meta.rating.asics.header') }}
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                {{ __('Select a base metric to compare miners or use quick filters by parameters below.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('rating.asics.show', 'profit') }}"
                class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-emerald-500/10 border border-emerald-500/30 shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">📈</span>
                        <h2
                            class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            {{ __('By net profit') }}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('A daily updated ranking of ASIC miners, sorted by net daily profitability in rubles, taking into account current cryptocurrency exchange rates.') }}
                    </p>
                </div>
                <div class="mt-5 flex items-center text-xs font-bold text-emerald-600 dark:text-emerald-400 gap-1">
                    <span>{{ __('View top') }}</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </a>

            <a href="{{ route('rating.asics.show', 'payback') }}"
                class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-indigo-500/10 border border-indigo-500/30 shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">⏱️</span>
                        <h2
                            class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ __('By return on investment (ROI)') }}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('Investment efficiency rating. Shows which miner models will most quickly return their investment at the current network difficulty.') }}
                    </p>
                </div>
                <div class="mt-5 flex items-center text-xs font-bold text-indigo-600 dark:text-indigo-400 gap-1">
                    <span>{{ __('View top') }}</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </a>
        </div>
    </section>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Tops by category') }}
            </h2>
        </div>

        @include('rating.asics.components.filters')
    </section>
</x-home-layout>
