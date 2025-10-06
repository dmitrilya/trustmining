<x-metrics-layout title="Хэшрейт сети {{ $coin->name }}" :header="__('Network hashrate') . ' ' . $coin->name" active="network_hashrate"
    description="История изменений и текущий показатель хэшрейта криптосети {{ $coin->name }} ({{ $coin->abbreviation }})">
    <div x-data="{ period: '3m', items: [] }" x-init="axios.get('{{ route('metrics.network.get_hashrate', ['coin' => $coin->name]) }}').then(r => {
        window.buildGraph(r.data.hashrates, period);
        items = r.data.hashrates.reverse().splice(0, 91);
    })">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6">
            <div class="flex justify-between items-start mb-3 xs:mb-4 lg:mb-6">
                <div class="bg-gray-100 size-7 rounded-md shadow-sm cursor-pointer border flex justify-center items-center md:hidden"
                    @click="show = !show">
                    <svg class="size-4 text-gray-800 dark:text-gray-200" aria-hidden="true" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5" />
                    </svg>
                </div>

                <div class="flex justify-end space-x-2 xs:space-x-3 sm:space-x-4 mb-3 xs:mb-4 lg:mb-6">
                    <div class="flex bg-gray-100 dark:bg-gray-700 rounded-s-lg rounded-e-lg overflow-hidden border h-7">
                        <div @click="period = '3m';window.xAxis.set('min', window.dateDiffs['3m'])"
                            :class="{
                                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                                    '3m',
                                ' text-gray-600 dark:text-gray-300': period != '3m'
                            }"
                            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                            {{ '3' . __('m') }}
                        </div>
                        <div @click="period = '6m';window.xAxis.set('min', window.dateDiffs['6m'])"
                            :class="{
                                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                                    '6m',
                                ' text-gray-600 dark:text-gray-300': period != '6m'
                            }"
                            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                            {{ '6' . __('m') }}
                        </div>
                        <div @click="period = '1y';window.xAxis.set('min', window.dateDiffs['1y'])"
                            :class="{
                                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                                    '1y',
                                ' text-gray-600 dark:text-gray-300': period != '1y'
                            }"
                            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                            {{ '1' . __('y') }}
                        </div>
                        <div @click="period = '3y';window.xAxis.set('min', window.dateDiffs['3y'])"
                            :class="{
                                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                                    '3y',
                                ' text-gray-600 dark:text-gray-300': period != '3y'
                            }"
                            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                            {{ '3' . __('y') }}
                        </div>
                        <div @click="period = 'all';window.xAxis.set('min', window.dateDiffs['all'])"
                            :class="{
                                'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                                    'all',
                                ' text-gray-600 dark:text-gray-300': period != 'all'
                            }"
                            class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                            {{ __('All') }}
                        </div>
                    </div>

                    <x-select name="coin_id" :key="$coin->id" :items="\App\Models\Coin::has('networkHashrates')
                        ->get()
                        ->map(
                            fn($coin) => [
                                'key' => $coin->id,
                                'value' => $coin->abbreviation,
                                'href' => route('metrics.network.hashrate', ['coin' => $coin->name]),
                            ],
                        )
                        ->keyBy('key')" :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                </div>
            </div>

            <div class="text-center my-4 xs:my-5 sm::my-6 md:my-7 lg:my-9">
                <h3
                    class="text-lg sm:text-xl lg:text-2xl text-gray-800 dark:text-gray-200 font-bold mb-2 sm:mb-3 lg:mb-4">
                    {{ __('Current hashrate') }}</h3>
                <div class="text-xs sm:text-sm lg:text-lg text-gray-500 dark:text-gray-400 mb-3 sm:mb-4 lg:mb-6">
                    {{ number_format($hashrate) }}</div>
            </div>

            <div id="graph" class="h-[25rem] sm:h-[35rem]"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg mt-4 sm:mt-6 p-2 sm:p-4 md:p-6">
            <div class="grid grid-cols-6 gap-2 sm:gap-3 mb-2 sm:mb-3">
                <div class="col-span-2 font-bold text-xs sm:text-sm lg:text-base text-gray-500 dark:text-gray-400">
                    {{ __('Date') }}</div>
                <div class="col-span-3 font-bold text-xs sm:text-sm lg:text-base text-gray-500 dark:text-gray-400">
                    {{ __('Network difficulty') }}</div>
                <div class="col-span-1 font-bold text-xs sm:text-sm lg:text-base text-gray-500 dark:text-gray-400">
                    {{ __('Change') }}</div>
            </div>
            <template x-for="(item, i) in items.slice(0, 90)" key="item.date">
                <div class="grid grid-cols-6 gap-2 sm:gap-3 mb-1 sm:mb-2">
                    <div class="col-span-2 text-xxs xs:text-xs sm:text-base lg:text-lg text-gray-700 dark:text-gray-300"
                        x-text="new Date(item.date).toLocaleString(window.locale, {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric',
                        })">
                    </div>
                    <div class="col-span-3 text-xxs xs:text-xs sm:text-base lg:text-lg text-gray-700 dark:text-gray-300"
                        x-text="item.value + ''"></div>
                    <div class="col-span-1 text-xxs xs:text-xs sm:text-base lg:text-lg"
                        :class="{
                            'text-green-500': item.value > items[i + 1].value,
                            'text-red-500': item.value < items[i + 1].value,
                            'text-gray-700 dark:text-gray-300': item.value == items[i + 1].value
                        }"
                        x-text="item.value > items[i + 1].value ? '+' + Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%' : Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%'">
                    </div>
                </div>
            </template>
            </table>
        </div>
    </div>
</x-metrics-layout>
