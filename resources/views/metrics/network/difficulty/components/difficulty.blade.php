@props(['blocks' => ['period', 'graph', 'prediction', 'history'], 'widjet' => false])

<div class="flex justify-between md:justify-end items-start mb-3 xs:mb-4 lg:mb-6">
    @if (!$widjet)
        <div class="bg-slate-100 dark:bg-slate-900 size-7 sm:size-8 rounded-md shadow-sm shadow-logo-color cursor-pointer border dark:border-slate-700 flex justify-center items-center md:hidden"
            @click="show = !show">
            <svg class="size-4 text-slate-900 dark:text-slate-100" aria-hidden="true" width="24" height="24"
                fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
            </svg>
        </div>
    @endif

    @if (in_array('period', $blocks))
        <div class="flex justify-end space-x-2 xs:space-x-3 sm:space-x-4">
            <div
                class="flex bg-slate-100 dark:bg-slate-900 rounded-s-lg rounded-e-lg overflow-hidden border dark:border-slate-700 h-7 sm:h-8">
                <div @click="period = '3m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3m'])"
                    :class="{
                        'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                            '3m',
                        ' text-slate-700 dark:text-slate-200': period != '3m'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                    {{ '3' . __('m') }}
                </div>
                <div @click="period = '6m';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['6m'])"
                    :class="{
                        'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                            '6m',
                        ' text-slate-700 dark:text-slate-200': period != '6m'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                    {{ '6' . __('m') }}
                </div>
                <div @click="period = '1y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['1y'])"
                    :class="{
                        'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                            '1y',
                        ' text-slate-700 dark:text-slate-200': period != '1y'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                    {{ '1' . __('y') }}
                </div>
                <div @click="period = '3y';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['3y'])"
                    :class="{
                        'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                            '3y',
                        ' text-slate-700 dark:text-slate-200': period != '3y'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                    {{ '3' . __('y') }}
                </div>
                <div @click="period = 'all';window.graph_chart.xAxes.values[0].set('min', window.dateDiffs['all'])"
                    :class="{
                        'text-slate-800 dark:text-slate-100 bg-slate-200 dark:bg-slate-800': period ==
                            'all',
                        ' text-slate-700 dark:text-slate-200': period != 'all'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-slate-300 dark:hover:bg-slate-700">
                    {{ __('All') }}
                </div>
            </div>

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
    @endif
</div>

<div class="text-center my-4 xs:my-5 sm::my-6 md:my-7 lg:my-9">
    <h3 class="text-lg sm:text-xl lg:text-2xl text-slate-900 dark:text-slate-100 font-bold mb-2 sm:mb-3 lg:mb-4">
        {{ __('Current difficulty') }}
    </h3>
    <div class="text-xs sm:text-sm lg:text-lg text-slate-600 dark:text-slate-300 mb-3 sm:mb-4 lg:mb-6">
        {{ number_format($difficulty->difficulty) }}
    </div>
    @if ($prediction && in_array('prediction', $blocks))
        <div class="text-xxs sm:text-xs lg:text-sm text-slate-700 dark:text-slate-200 mb-2 sm:mb-3 lg:mb-4">
            {{ __('Blocks before recalculation') }}: <span class="font-bold">{{ $difficulty->need_blocks }}</span>
            ({{ $needBlocksTime }})
        </div>

        <div class="text-sm sm:text-base lg:text-lg text-slate-900 dark:text-slate-100 font-bold">
            {{ __('Next difficulty prediction') }}: <span
                class="{{ $prediction > 0 ? 'text-green-500' : 'text-red-400' }}">
                @if ($prediction > 0)
                    +
                @endif{{ $prediction }}%
            </span>
        </div>
    @endif
</div>

@if (in_array('graph', $blocks))
    <div id="graph" class="h-[25rem] sm:h-[35rem]"></div>
@endif
