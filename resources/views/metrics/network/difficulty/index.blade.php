<x-metrics-layout title="Сложность сети {{ $coin->name }} | TRUSTMINING" :header="__('Network difficulty') . ' ' . $coin->name" active="network_difficulty"
    description="История изменений, текущий показатель и прогноз следующей сложности криптосети {{ $coin->name }} ({{ $coin->abbreviation }})">
    @vite(['resources/js/graph.js'])

    <div x-data="{ period: '1y', items: [] }" x-init="axios.get('{{ route('metrics.network.get_difficulty', ['coin' => strtolower($coin->name)]) }}').then(r => {
        window.buildGraph(r.data.difficulties, period, 'graph', 'value');
        difficulties = r.data.difficulties.reverse().slice(0, 366);
        items = difficulties.slice(0, 365).filter((difficulty, i) => difficulty.value != difficulties[i + 1].value);
    })">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
            @include('metrics.network.difficulty.components.difficulty')
        </div>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg mt-4 sm:mt-6 p-2 sm:p-4 md:p-6">
            <div class="grid grid-cols-6 gap-1 sm:gap-3 mb-2 sm:mb-3">
                <div class="col-span-2 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Date') }}</div>
                <div class="col-span-3 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Network difficulty') }}</div>
                <div class="col-span-1 font-bold text-xs sm:text-sm lg:text-base text-slate-500">
                    {{ __('Change') }}</div>
            </div>
            <template x-for="(item, i) in items.slice(0, items.length - 1)" key="item.date">
                <div class="grid grid-cols-6 gap-1 sm:gap-3 mb-1 sm:mb-2">
                    <div class="col-span-2 text-xxs xs:text-xs sm:text-base lg:text-lg text-slate-800 dark:text-slate-200"
                        x-text="new Date(item.date).toLocaleString(window.locale, {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                        })">
                    </div>
                    <div class="col-span-3 text-xxs xs:text-xs sm:text-base lg:text-lg text-slate-800 dark:text-slate-200"
                        x-text="item.value"></div>
                    <div class="col-span-1 text-xxs xs:text-xs sm:text-base lg:text-lg"
                        :class="{
                            'text-green-500': item.value > items[i + 1].value,
                            'text-red-500': item.value < items[i +
                                1].value,
                            'text-slate-700 dark:text-slate-200': item.value == items[i + 1].value
                        }"
                        x-text="item.value > items[i + 1].value ? '+' + Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%' : Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%'">
                    </div>
                </div>
            </template>
        </div>
    </div>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                {{ __('Miners for') }} {{ $coin->abbreviation }}
            </h2>
        </div>

        <div>
            @include('home.components.carousel', [
                'items' => $ads,
                'blade' => 'ad.components.card',
                'model' => 'ad',
            ])
        </div>
    </section>

    @include('metrics.network.difficulty.components.faq')
</x-metrics-layout>
