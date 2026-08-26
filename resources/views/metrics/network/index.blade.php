<x-home-layout :data="$__data" title="Метрики и статистика криптосетей - TRUSTMINING" :header="__('Cryptonetwork metrics')"
    description="Актуальные показатели блокчейн-сетей. Сложность майнинга и общий хэшрейт сетей Bitcoin, Litecoin и других популярных криптовалют">
    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :href="route('metrics')" :name="__('Metrics')" />
        <x-breadcrumbs.breadcrumb position="2" :name="__('Cryptonetwork')" />
    </x-breadcrumbs.breadcrumbs>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Cryptonetwork') }}
            </h2>
        </div>

        @php
            $difficultyCoins = \App\Models\Database\Coin::has('networkDifficulties')
                ->select(['name', 'abbreviation'])
                ->get();
            $hashrateCoins = \App\Models\Database\Coin::has('networkHashrates')
                ->select(['name', 'abbreviation'])
                ->get();
        @endphp

        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col">
                    <h3
                        class="flex items-center gap-2 font-bold text-lg sm:text-xl text-slate-800 dark:text-slate-200 mb-4 pb-2 border-b border-slate-300 dark:border-slate-700">
                        <span>⚙️</span>{{ __('Network difficulty') }}
                    </h3>

                    <div class="grid grid-cols-2 xs:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                        @foreach ($difficultyCoins as $coin)
                            <a href="{{ route('metrics.network.difficulty', strtolower($coin->name)) }}"
                                class="flex items-center gap-2 p-2 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500">
                                <img src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}" alt="{{ $coin->name }} icon" class="w-5 h-5">
                                <div class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $coin->name }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col">
                    <h3
                        class="flex items-center gap-2 font-bold text-lg sm:text-xl text-slate-800 dark:text-slate-200 mb-4 pb-2 border-b border-slate-300 dark:border-slate-700">
                        <span>⚡</span>{{ __('Network hashrate') }}
                    </h3>

                    <div class="grid grid-cols-2 xs:grid-cols-3 lg:grid-cols-2 xl:grid-cols-3 gap-2">
                        @foreach ($hashrateCoins as $coin)
                            <a href="{{ route('metrics.network.hashrate', strtolower($coin->name)) }}"
                                class="flex items-center gap-2 p-2 rounded-lg bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-500">
                                <img src="{{ Storage::url('public/coins/' . $coin->abbreviation . '.webp') }}" alt="{{ $coin->name }} icon" class="w-5 h-5">
                                <div class="text-xs text-slate-600 dark:text-slate-400 truncate">{{ $coin->name }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>
