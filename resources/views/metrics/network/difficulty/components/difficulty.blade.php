@props(['blocks' => ['period', 'graph', 'prediction', 'dynamics', 'history'], 'widjet' => false])

@if (!$widjet)
    <div class="flex justify-between lg:justify-end items-start">
        <div class="bg-slate-100 dark:bg-slate-900 w-7 h-7 sm:w-8 sm:h-8 rounded-md shadow-sm shadow-logo-color cursor-pointer border dark:border-slate-700 flex justify-center items-center lg:hidden"
            @click="show = !show">
            <svg class="w-4 h-4 text-slate-900 dark:text-slate-100" aria-hidden="true" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
            </svg>
        </div>

        <div class="flex justify-end space-x-2 xs:space-x-3 sm:space-x-4">
            <x-select name="coin_id" :key="$coin->id" :items="\App\Models\Database\Coin::has('networkDifficulties')
                ->get()
                ->map(
                    fn($coin) => [
                        'key' => $coin->id,
                        'value' => $coin->abbreviation,
                        'href' => route('metrics.network.difficulty', ['coin' => strtolower($coin->name)]),
                    ],
                )
                ->keyBy('key')" :icon="['type' => 'value', 'path' => '/storage/coins/']" />

        </div>
    </div>
@endif

<div class="my-4 lg:my-8" x-data="{
    diff30d: null,
    diff90d: null,
    diff180d: null,
    diff1y: null,

    calculateDiff(current, past) {
        if (!past || !current) return null;
        let change = ((current - past) / past) * 100;
        return change.toFixed(2);
    }
}" x-init="$watch('items', value => {
    if (value && value.length > 0) {
        let current = value[0].value;
        let d30 = value.find(i => new Date(i.date) <= new Date(Date.now() - 30 * 24 * 60 * 60 * 1000));
        let d90 = value.find(i => new Date(i.date) <= new Date(Date.now() - 90 * 24 * 60 * 60 * 1000));
        let d180 = value.find(i => new Date(i.date) <= new Date(Date.now() - 180 * 24 * 60 * 60 * 1000));
        let d365 = value.at(-1);

        diff30d = d30 ? calculateDiff(current, d30.value) : null;
        diff90d = d90 ? calculateDiff(current, d90.value) : null;
        diff180d = d180 ? calculateDiff(current, d180.value) : null;
        diff1y = d365 ? calculateDiff(current, d365.value) : null;
    }
})">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 lg:gap-4 mb-2 lg:mb-4">
        <div
            class="bg-white/40 dark:bg-slate-900/40 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 uppercase block mb-2">
                    {{ __('Current difficulty') }}
                </h2>
                <span
                    class="text-xl xs:text-2xl md:text-base lg:text-xl xl:text-2xl font-black text-slate-800 dark:text-slate-200">
                    {{ number_format($difficulty->difficulty) }}
                </span>
            </div>
            <div class="mt-3 flex items-center text-xxs lg:text-xs text-slate-500">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>
                {{ __('Current value for today') }}
            </div>
        </div>

        @if ($prediction && in_array('prediction', $blocks))
            <div
                class="bg-white/40 dark:bg-slate-900/40 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 uppercase block mb-2">
                        {{ __('Next difficulty prediction') }}
                    </h2>
                    <span
                        class="text-2xl xl:text-3xl font-black tracking-tight {{ $prediction > 0 ? 'text-green-500' : 'text-red-400' }}">
                        {{ $prediction > 0 ? '+' : '' }}{{ $prediction }}%
                    </span>
                </div>
                <div class="mt-3 text-xxs lg:text-xs text-slate-500">
                    {{ __('Expected trend when recalculated') }}
                </div>
            </div>

            <div
                class="bg-white/40 dark:bg-slate-900/40 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm">
                <div>
                    <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-500 uppercase block mb-2">
                        {{ __('Blocks before recalculation') }}
                    </h2>
                    <span class="text-lg lg:text-xl font-bold text-slate-800 dark:text-slate-200">
                        {{ $difficulty->need_blocks }}
                    </span>
                    <span class="text-xxs text-slate-500">/ 2016</span>
                </div>
                <div class="text-right">
                    <h3 class="sr-only">{{ __('Time left until the calculation') }}</h3>
                    <span class="text-xxs xs:text-sm md:text-xs lg:text-sm text-amber-500">{{ $needBlocksTime }}</span>
                </div>

                @php
                    $blocksPassed = max(0, 2016 - $difficulty->need_blocks);
                    $progressPercent = ($blocksPassed / 2016) * 100;
                @endphp
                <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-2 mt-2 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-500 h-2 rounded-full transition-all duration-500"
                        style="width: {{ $progressPercent }}%">
                    </div>
                </div>
                <div class="flex justify-between items-center mt-1.5 text-xxs lg:text-xs text-slate-500">
                    <span>Прогресс эпохи</span>
                    <span>{{ round($progressPercent) }}%</span>
                </div>
            </div>
        @endif
    </div>

    @if (in_array('dynamics', $blocks))
        <div>
            <h2 class="sr-only">
                {{ __('Relative change in network difficulty') }}
            </h2>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 lg:gap-4">
                <div
                    class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span
                        class="text-xxs sm:text-xs text-slate-500 block font-semibold tracking-wider uppercase mb-1 lg:mb-2">
                        30 {{ __('days') }}
                    </span>
                    <span class="text-xs xs:text-sm lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff30d ? (diff30d > 0 ? '+' + diff30d : diff30d) + '%' : '...'"
                        :class="diff30d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div
                    class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span
                        class="text-xxs sm:text-xs text-slate-500 block font-semibold tracking-wider uppercase mb-1 lg:mb-2">
                        90 {{ __('days') }}
                    </span>
                    <span class="text-xs xs:text-sm lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff90d ? (diff90d > 0 ? '+' + diff90d : diff90d) + '%' : '...'"
                        :class="diff90d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div
                    class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span
                        class="text-xxs sm:text-xs text-slate-500 block font-semibold tracking-wider uppercase mb-1 lg:mb-2">
                        180 {{ __('days') }}
                    </span>
                    <span class="text-xs xs:text-sm lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff180d ? (diff180d > 0 ? '+' + diff180d : diff180d) + '%' : '...'"
                        :class="diff180d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div
                    class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span
                        class="text-xxs sm:text-xs text-slate-500 block font-semibold tracking-wider uppercase mb-1 lg:mb-2">
                        1 {{ __('year') }}
                    </span>
                    <span class="text-xs xs:text-sm lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff1y ? (diff1y > 0 ? '+' + diff1y : diff1y) + '%' : '...'"
                        :class="diff1y > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

@if (in_array('graph', $blocks))
    <div class="overflow-hidden">
        @if (in_array('period', $blocks))
            <div class="flex items-center justify-between mb-4 lg:mb-6">
                <h2 class="text-lg sm:text-xl text-slate-800 dark:text-slate-200 font-bold">
                    {{ __('Online chart') }}
                </h2>

                <div
                    class="flex bg-slate-100 dark:bg-slate-900 rounded-lg overflow-hidden border dark:border-slate-700 h-7 sm:h-8">
                    <div @click="period = '3m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3m'])"
                        :class="{
                            'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                                '3m',
                            'text-slate-700 dark:text-slate-200': period != '3m'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                        {{ '3' . __('m') }}
                    </div>
                    <div @click="period = '6m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['6m'])"
                        :class="{
                            'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                                '6m',
                            'text-slate-700 dark:text-slate-200': period != '6m'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                        {{ '6' . __('m') }}
                    </div>
                    <div @click="period = '1y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['1y'])"
                        :class="{
                            'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                                '1y',
                            'text-slate-700 dark:text-slate-200': period != '1y'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                        {{ '1' . __('y') }}
                    </div>
                    <div @click="period = '3y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3y'])"
                        :class="{
                            'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                                '3y',
                            'text-slate-700 dark:text-slate-200': period != '3y'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                        {{ '3' . __('y') }}
                    </div>
                    <div @click="period = 'all';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['all'])"
                        :class="{
                            'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                                'all',
                            'text-slate-700 dark:text-slate-200': period != 'all'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                        {{ __('All') }}
                    </div>
                </div>
            </div>
        @endif

        <div id="graph" class="h-[25rem] sm:h-[35rem]"></div>
    </div>
@endif
