<x-metrics-layout title="Сложность сети {{ $coin->name }}" :header="__('Network difficulty') . ' ' . $coin->name" active="network_difficulty"
    description="История изменений и текущий показатель сложности криптосети {{ $coin->name }} ({{ $coin->abbreviation }})">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6" x-data="{ period: '3m' }"
        x-init="axios.get('{{ route('metrics.network.get_difficulty', ['coin' => $coin->name]) }}').then(r => window.buildGraph(r.data.difficulties, period))">
        <div class="flex justify-end space-x-2 xs:space-x-3 sm:space-x-4 mb-3 xs:mb-4 lg:mb-6">
            <div class="flex bg-gray-100 dark:bg-gray-700 rounded-s-lg rounded-e-lg overflow-hidden">
                <div @click="period = '3m';window.buildGraph(window.graph_data, period)"
                    :class="{
                        'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                            '3m',
                        ' text-gray-600 dark:text-gray-300': period != '3m'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                    {{ '3' . __('m') }}
                </div>
                <div @click="period = '6m';window.buildGraph(window.graph_data, period)"
                    :class="{
                        'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                            '6m',
                        ' text-gray-600 dark:text-gray-300': period != '6m'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                    {{ '6' . __('m') }}
                </div>
                <div @click="period = '1y';window.buildGraph(window.graph_data, period)"
                    :class="{
                        'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                            '1y',
                        ' text-gray-600 dark:text-gray-300': period != '1y'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                    {{ '1' . __('y') }}
                </div>
                <div @click="period = '3y';window.buildGraph(window.graph_data, period)"
                    :class="{
                        'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                            '3y',
                        ' text-gray-600 dark:text-gray-300': period != '3y'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                    {{ '3' . __('y') }}
                </div>
                <div @click="period = 'all';window.buildGraph(window.graph_data, period)"
                    :class="{
                        'text-gray-800 dark:text-gray-200 bg-gray-200 dark:bg-gray-600': period ==
                            'all',
                        ' text-gray-600 dark:text-gray-300': period != 'all'
                    }"
                    class="p-2 xs:px-2.5 sm:px-3 text-xxs sm:text-xs cursor-pointer hover:bg-gray-300 dark:hover:bg-gray-500">
                    {{ __('All') }}
                </div>
            </div>

            <x-select name="coin_id" :key="$coin->id" :items="\App\Models\Coin::has('networkDifficulties')
                ->get()
                ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation, 'href' => route('metrics.network.difficulty', ['coin' => $coin->name])])
                ->keyBy('key')" :icon="['type' => 'value', 'path' => '/storage/coins/']" />
        </div>

        <div class="text-center my-3 xs:my-4 sm::my-5 md:my-7 lg:my-9">
            <h3 class="text-lg sm:text-xl lg:text-2xl text-gray-800 dark:text-gray-200 font-bold mb-2 sm:mb-3 lg:mb-4">
                {{ __('Current difficulty') }}</h3>
            <div class="text-xs sm:text-sm lg:text-lg text-gray-500 dark:text-gray-400 mb-3 sm:mb-4 lg:mb-6">
                {{ $difficulty }}</div>
            @if ($prediction)
                <div class="text-sm sm:text-base lg:text-lg text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('Prediction') }}: <span
                        class="text-gray-500 dark:text-gray-400 {{ $prediction > 0 ? 'text-green-500' : 'text-red-400' }}">{{ $prediction > 0 ? '+' : '-' }}{{ $prediction }}</span>
                </div>
            @endif
        </div>

        <div id="graph" class="h-[35rem]"></div>
    </div>
</x-metrics-layout>
