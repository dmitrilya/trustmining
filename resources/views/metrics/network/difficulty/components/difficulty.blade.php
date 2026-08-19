@props(['blocks' => ['period', 'graph', 'prediction', 'dynamics', 'history'], 'widjet' => false])

@if (!$widjet)
    <div class="flex justify-between items-center">
        <div
            class="text-xxs xxs:text-xs px-2 xs:px-4 py-1.5 xs:py-2 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-600 text-slate-600 dark:text-slate-400 uppercase tracking-widest">
            {{ __('Updated') }}: <span class="text-indigo-500">{{ Carbon\Carbon::createFromTimestamp($difficulty->created_at)->diffForHumans() }}</span>
        </div>

        <div class="flex justify-end space-x-2 xs:space-x-3 sm:space-x-4">
            <x-inputs.select name="coin_id" :key="$coin->id" :items="\App\Models\Database\Coin::has('networkDifficulties')
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

<div class="my-4 lg:my-6" x-data="{
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
    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 lg:gap-4 items-stretch">
        <div
            class="md:col-span-2 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm flex flex-col justify-between">
            <div>
                <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1.5">
                    {{ __('Current difficulty') }}
                </h2>
                <span class="text-xl xs:text-2xl lg:text-3xl font-black text-slate-800 dark:text-slate-200 break-all">
                    {{ number_format($difficulty->difficulty) }}
                </span>
            </div>
            <div class="mt-2 flex items-center text-xxs lg:text-xs text-slate-500">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500 mr-1.5 animate-pulse"></span>
                {{ __('Current value for today') }}
            </div>
        </div>

        @if ($prediction && in_array('prediction', $blocks))
            <div
                class="md:col-span-3 bg-white/40 dark:bg-slate-900/40 p-2 sm:p-4 rounded-xl border border-slate-300 dark:border-slate-700 shadow-sm flex flex-col justify-between gap-2 sm:gap-4">
                <div class="flex justify-between gap-2 border-b border-slate-300 dark:border-slate-700 pb-2">
                    <div style="max-width: 60%" class="flex flex-col justify-between">
                        <div>
                            <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1.5">
                                {{ __('Next difficulty prediction') }}
                            </h2>
                            <span class="text-xl xs:text-3xl font-black {{ $prediction > 0 ? 'text-green-500' : 'text-red-400' }}">
                                {{ $prediction > 0 ? '+' : '' }}{{ $prediction }}%
                            </span>
                        </div>
                        <span class="block text-xxs sm:text-xs text-slate-500 mt-0.5 leading-tight">
                            {{ __('Expected trend when recalculated') }}
                        </span>
                    </div>

                    <div class="text-right flex-1 flex flex-col justify-between">
                        <div>
                            <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1.5">
                                {{ __('Blocks before recalculation') }}
                            </h2>
                            <div class="flex items-baseline justify-end gap-1">
                                <span class="xs:text-lg sm:text-xl font-bold text-slate-800 dark:text-slate-200">
                                    {{ $difficulty->need_blocks }}
                                </span>
                                <span class="text-xs text-slate-500">/ 2016</span>
                            </div>
                        </div>
                        <div class="mt-0.5">
                            <h3 class="sr-only">{{ __('Time left until the calculation') }}</h3>
                            <span class="text-xxs xxs:text-sm text-amber-500 font-medium block leading-tight">{{ $needBlocksTime }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $blocksPassed = max(0, 2016 - $difficulty->need_blocks);
                    $progressPercent = ($blocksPassed / 2016) * 100;
                @endphp
                <div class="w-full">
                    <div class="w-full bg-slate-200 dark:bg-slate-800 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 h-1.5 rounded-full transition-all duration-500"
                            style="width: {{ $progressPercent }}%">
                        </div>
                    </div>
                    <div class="flex justify-between items-center mt-1.5 text-xxs lg:text-xs text-slate-500">
                        <span>{{ __('Progress of the era') }}</span>
                        <span>{{ round($progressPercent) }}%</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (in_array('dynamics', $blocks))
        <div class="mt-2 lg:mt-4">
            <h2 class="sr-only">
                {{ __('Relative change in network difficulty') }}
            </h2>

            <div class="grid grid-cols-2 xs:grid-cols-4 gap-2 lg:gap-4">
                <div class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 block tracking-wider uppercase mb-1 lg:mb-2">
                        30 {{ __('days') }}
                    </span>
                    <span class="sm:text-lg lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff30d ? (diff30d > 0 ? '+' + diff30d : diff30d) + '%' : '...'" :class="diff30d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 block tracking-wider uppercase mb-1 lg:mb-2">
                        90 {{ __('days') }}
                    </span>
                    <span class="sm:text-lg lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff90d ? (diff90d > 0 ? '+' + diff90d : diff90d) + '%' : '...'" :class="diff90d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 block tracking-wider uppercase mb-1 lg:mb-2">
                        180 {{ __('days') }}
                    </span>
                    <span class="sm:text-lg lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff180d ? (diff180d > 0 ? '+' + diff180d : diff180d) + '%' : '...'" :class="diff180d > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>

                <div class="bg-white/40 dark:bg-slate-900/40 p-2 lg:p-4 rounded-xl border border-slate-300 dark:border-slate-700 text-center shadow-sm">
                    <span class="text-xxs sm:text-xs text-slate-600 dark:text-slate-400 block tracking-wider uppercase mb-1 lg:mb-2">
                        1 {{ __('year') }}
                    </span>
                    <span class="sm:text-lg lg:text-xl xl:text-2xl font-bold tracking-tight"
                        x-text="diff1y ? (diff1y > 0 ? '+' + diff1y : diff1y) + '%' : '...'" :class="diff1y > 0 ? 'text-green-500' : 'text-red-400'">
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>

@if (in_array('graph', $blocks))
    <div class="overflow-hidden mt-2 lg:mt-4">
        @if (in_array('period', $blocks))
            <div class="flex items-center justify-between">
                <h2 class="text-lg sm:text-xl text-slate-800 dark:text-slate-200 font-extrabold">
                    {{ __('Online chart') }}
                </h2>

                <div class="flex bg-white/40 dark:bg-slate-900/40 rounded-lg overflow-hidden border dark:border-slate-700">
                    <div @click="period = '3m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3m'])"
                        :class="{
                            'text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40': period ==
                                '3m',
                            'text-slate-600 dark:text-slate-400': period != '3m'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs xs:text-xs cursor-pointer hover:text-slate-800 dark:hover:text-slate-200">
                        {{ '3' . __('m') }}
                    </div>
                    <div @click="period = '6m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['6m'])"
                        :class="{
                            'text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40': period ==
                                '6m',
                            'text-slate-600 dark:text-slate-400': period != '6m'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs xs:text-xs cursor-pointer hover:text-slate-800 dark:hover:text-slate-200">
                        {{ '6' . __('m') }}
                    </div>
                    <div @click="period = '1y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['1y'])"
                        :class="{
                            'text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40': period ==
                                '1y',
                            'text-slate-600 dark:text-slate-400': period != '1y'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs xs:text-xs cursor-pointer hover:text-slate-800 dark:hover:text-slate-200">
                        {{ '1' . __('y') }}
                    </div>
                    <div @click="period = '3y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3y'])"
                        :class="{
                            'text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40': period ==
                                '3y',
                            'text-slate-600 dark:text-slate-400': period != '3y'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs xs:text-xs cursor-pointer hover:text-slate-800 dark:hover:text-slate-200">
                        {{ '3' . __('y') }}
                    </div>
                    <div @click="period = 'all';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['all'])"
                        :class="{
                            'text-indigo-500 bg-indigo-50 dark:bg-indigo-950/40': period ==
                                'all',
                            'text-slate-600 dark:text-slate-400': period != 'all'
                        }"
                        class="p-2 xs:px-2.5 sm:px-3 text-xxs xs:text-xs cursor-pointer hover:text-slate-800 dark:hover:text-slate-200">
                        {{ __('All') }}
                    </div>
                </div>
            </div>
        @endif

        <div id="graph" class="h-[20rem] sm:h-[30rem] mt-4 lg:mt-6"></div>
    </div>
@endif
