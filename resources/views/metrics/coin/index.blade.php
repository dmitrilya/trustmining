<x-home-layout :data="$__data" title="Курсы и метрики криптомонет - TRUSTMINING" :header="__('Coin metrics')"
    description="Следите за стоимостью криптовалют онлайн. Актуальные курсы монет, графики изменений цен и рыночная аналитика в реальном времени">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :href="route('metrics')" :name="__('Metrics')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__('Coin')" />
    </x-breadcrumbs.breadcrumbs>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Coin') }}
            </h2>
        </div>

        @php
            $rateCoins = \App\Models\Database\Coin::has('coinRates')
                ->select(['name', 'abbreviation'])
                ->get();
        @endphp

        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6">
            <div class="flex flex-col">
                <h3
                    class="flex items-center gap-2 font-bold text-lg sm:text-xl text-slate-800 dark:text-slate-200 mb-4 pb-2 border-b border-slate-300 dark:border-slate-700">
                    <span>📈</span>{{ __('Coin rate') }}
                </h3>

                <div class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                    @foreach ($rateCoins as $coin)
                        <a href="{{ route('metrics.coin.rate', strtolower($coin->name)) }}"
                            class="flex items-center gap-2 p-2 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500">
                            <img src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}" alt="{{ $coin->name }} icon" class="w-5 h-5">
                            <div class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $coin->name }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
