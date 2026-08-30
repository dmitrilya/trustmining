<x-home-layout :data="$__data" :title="__('meta.rating.title', ['year' => now()->year])" :description="__('meta.rating.description')">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :name="__('meta.rating.breadcrumb')" />
    </x-breadcrumbs.breadcrumbs>

    <section class="mb-6 sm:mb-8 lg:mb-10">
        <h1 class="font-extrabold text-2xl sm:text-3xl text-slate-800 dark:text-slate-200 mb-4">
            {{ __('meta.rating.header') }}
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="{{ route('rating.hostings.show', ['type' => 'best']) }}"
                class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-amber-500/10 border border-amber-500/30 shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">🏢</span>
                        <h2
                            class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                            {{ __('Hosting rating') }}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('A reliable catalog of data centers and hotels for mining. Compare electricity prices, security levels, and uptime guarantees.') }}
                    </p>
                </div>
                <div class="mt-5 flex items-center text-xs font-bold text-amber-600 dark:text-amber-400 gap-1">
                    <span>{{ __('View rating') }}</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </a>

            <a href="{{ route('rating.asics') }}"
                class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-emerald-500/10 border border-emerald-500/30 shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">⚡</span>
                        <h2
                            class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                            {{ __('ASIC miners rating') }}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('Daily updated list of mining hardware. Compare hash rate, power consumption, and equipment efficiency in real time.') }}
                    </p>
                </div>
                <div class="mt-5 flex items-center text-xs font-bold text-emerald-600 dark:text-emerald-400 gap-1">
                    <span>{{ __('View rating') }}</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </a>

            <a href="{{ route('rating.companies.show') }}"
                class="group relative flex flex-col justify-between p-2 sm:p-4 lg:p-6 rounded-xl bg-indigo-500/10 border border-indigo-500/30 shadow-md transition-all duration-300">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-2xl">🌟</span>
                        <h2
                            class="font-black text-xl text-slate-800 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            {{ __('Companies rating') }}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ __('Independent ranking of hardware suppliers and service providers based on verified customer reviews and reputation.') }}
                    </p>
                </div>
                <div class="mt-5 flex items-center text-xs font-bold text-indigo-600 dark:text-indigo-400 gap-1">
                    <span>{{ __('View rating') }}</span>
                    <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                </div>
            </a>
        </div>
    </section>
</x-home-layout>
