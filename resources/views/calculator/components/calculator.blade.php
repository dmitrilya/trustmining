<div itemscope itemtype="https://schema.org/ViewAction"
    class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color rounded-lg p-2 pt-3 sm:p-4 xl:col-span-3 min-h-[616px] md:min-h-[460px]">
    <meta itemprop="name"
        content="{{ __('Income calculator') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }}" />
    <meta itemprop="description"
        content="{{ __('Calculate revenue, expenses, profit, and ROI for an ASIC miner') }} {{ $selModel->asicBrand->name }} {{ $selModel->name }} {{ $selVersion->hashrate }}{{ $selVersion->measurement }} {{ __('in a convenient mining calculator') }}" />

    <div itemprop="object" itemscope itemtype="https://schema.org/Product" class="md:grid grid-cols-5"
        x-data="{ currency: 'RUB', tariff: 5, version: {{ $selVersion }}, profitNumber: 0, fee: 0, count: 1, uptime: 100, difficultyGrowth: 0 }" x-init="fee = version.profits[0].coins[0].fee">
        <div class="md:p-6 lg:p-9 xl:p-12 col-span-2">
            @include('calculator.components.schema')

            @include('calculator.components.selectversion', [
                'selectedModel' => $selModel,
                'selectedVersion' => $selVersion,
            ])

            @include('calculator.components.expenses')

            <template x-if="version !== null">
                <div class="mt-6 sm:mt-8 lg:mt-10">
                    <div class="hidden md:block mt-6">
                        <h2 class="sr-only">{{ __('Reviews') }}</h2>
                        <div class="flex items-center" x-data="{ momentRating: version.reviews_avg }">
                            <x-rating></x-rating>

                            <a :href="'/database/' + version.brand_name + '/' + version.model_name + '/reviews'"
                                class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                <span x-text="version.reviews_count"></span>
                                {{ __('reviews') }}
                            </a>
                        </div>
                    </div>
                    <div class="mt-3 sm:mt-4 space-y-1 sm:space-y-2">
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Algorithm') }}:
                            <span class="text-gray-900 dark:text-gray-100 font-bold" x-text="version.algorithm"></span>
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Power') }}:
                            <span class="text-gray-900 dark:text-gray-100 font-bold"
                                x-text="version.efficiency * version.hashrate"></span> W
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Average price') }}: <span class="text-gray-900 dark:text-gray-100 font-bold"
                                x-text="version.price ? version.price + ' USDT' : '{{ __('No data') }}'"></span>
                        </div>
                    </div>
                    <template x-if="version.ads.length">
                        <a class="pt-3 sm:pt-4 lg:pt-6 w-fit"
                            x-bind:href="version ? '/ads/miners?model=' + version.model_name : ' # '">
                            <x-primary-button class="text-xxs sm:text-xs">{{ __('Find ads') }}</x-primary-button>
                        </a>
                    </template>
                </div>
            </template>
        </div>

        <div class="mt-6 md:mt-0 md:p-6 lg:p-9 xl:p-12 md:border-l border-gray-300 dark:border-zinc-700 col-span-3">
            <div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
                <h2 class="text-xs sm:text-sm text-gray-700 dark:text-gray-200">
                    {{ __('Calculation result') }}</h2>
                <div class="flex cursor-pointer mx-3">
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'RUB',
                            'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': currency ==
                                'USDT'
                        }"
                        class="p-1 rounded-l border border-r-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                        @click="currency = 'RUB'">RUB</button>
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'USDT',
                            'bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-zinc-950 dark:hover:bg-zinc-900 dark:text-gray-100': currency ==
                                'RUB'
                        }"
                        class="p-1 rounded-r border border-l-0 border-gray-300 dark:border-zinc-700 text-xxs font-semibold"
                        @click="currency = 'USDT'">USDT</button>
                </div>
            </div>

            <template x-if="version !== null">
                <div x-data="{
                    get dailyProfit() {
                        return (version.profits[profitNumber].profit * (100 - fee) * uptime / 10000) * count / (currency == 'RUB' ? {{ $rub }} : 1);
                    },
                    get dailyConsumption() {
                        return version.efficiency * version.hashrate * tariff * 24 * uptime / 100 * count * (currency == 'USDT' ? {{ $rub }} : 1);
                    },
                    get dailyIncome() {
                        return (version.profits[profitNumber].profit * (100 - fee) * uptime / 10000 - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 * uptime / 100000) * count;
                    }
                }">
                    <div class="grid grid-cols-4 gap-2 sm:gap-4">
                        <div></div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Income') }}
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Expense') }}
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Profit') }}
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Day') }}
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(calculateProfitCAGR(dailyProfit, 1, difficultyGrowth) * 100) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(dailyConsumption / 10) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round((calculateProfitCAGR(dailyProfit, 1, difficultyGrowth) - dailyConsumption / 1000) * 100) / 100">
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Month') }}
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(calculateProfitCAGR(dailyProfit, 30, difficultyGrowth) * 100) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(dailyConsumption * 30 / 10) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round((calculateProfitCAGR(dailyProfit, 30, difficultyGrowth) - dailyConsumption * 30 / 1000) * 100) / 100">
                        </div>
                        <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300">
                            {{ __('Year') }}
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(calculateProfitCAGR(dailyProfit, 365, difficultyGrowth) * 100) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round(dailyConsumption * 365 / 10) / 100">
                        </div>
                        <div class="text-xs xs:text-sm text-gray-900 dark:text-gray-100 font-bold"
                            x-text="Math.round((calculateProfitCAGR(dailyProfit, 365, difficultyGrowth) - dailyConsumption * 365 / 1000) * 100) / 100">
                        </div>
                    </div>

                    <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300 mt-6 sm:mt-7 lg:mt-8">
                        {{ __('Payback') }}:
                        <span class="text-gray-900 dark:text-gray-100 font-bold"
                            x-text="version.price ? dailyIncome > 0 ? Math.round(dailyIncome) + ' {{ __('Days') }}' : '∞' : '{{ __('No data') }}'"></span>
                    </div>

                    <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-200 mt-6 sm:mt-7 lg:mt-8">
                        {{ __('Coins per day') }}</p>

                    <template x-for="(profit, i) in version.profits" :key="'profit_' + i">
                        <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer"
                            @click="profitNumber = i, fee = version.profits[i].coins[0].fee">
                            <div>
                                <label class="flex items-center">
                                    <input type="radio" name="profitNumber" :value="i"
                                        :aria-label="'{{ __('Change calculation to') }}' + ' ' + profit.coins[0].name"
                                        :checked="profitNumber == i"
                                        class="mr-2 w-3 h-3 sm:w-4 sm:h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-zinc-800 dark:border-zinc-700 cursor-pointer">
                                </label>
                            </div>
                            <template x-for="coin in profit.coins" :key="coin.abbreviation">
                                <div>
                                    <div class="flex items-center">
                                        <img :src="'/storage/coins/' + coin.abbreviation + '.webp'"
                                            :alt="coin.name" class="w-3 xs:w-4 sm:w-5 mr-1 xs:mr-2">
                                        <div>
                                            <div class="text-xxs xs:text-xs text-gray-600 dark:text-gray-300"
                                                x-text="coin.abbreviation">
                                            </div>
                                            <div class="text-xxs xs:text-xs text-gray-500 dark:text-gray-400"
                                                x-text="coin.name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-xxs xs:text-xs text-gray-700 dark:text-gray-200 font-bold mt-1"
                                        x-text="version ? Math.round(version.hashrate * coin.profit * version.coef * 100000000) / 100000000 : 0">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    <a class="block mt-6 xl:mt-8"
                        x-bind:href="version ? ('/database/' + version.brand_name + '/' + version.model_name) : '#'">
                        <x-secondary-button>{{ __('More details about miner') }}</x-secondary-button>
                    </a>
                </div>
            </template>
        </div>
    </div>
</div>
