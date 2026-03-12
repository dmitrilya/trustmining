<div class="xl:col-span-3">
    <div itemscope itemtype="https://schema.org/ViewAction"
        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-md shadow-logo-color rounded-xl p-2 pt-3 sm:p-4 min-h-[616px] md:min-h-[460px]">
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

                <div class="hidden md:block">
                    <template x-if="version !== null">
                        <div class="mt-6 sm:mt-8 lg:mt-10">
                            <div class="mt-6">
                                <h2 class="sr-only">{{ __('Reviews') }}</h2>
                                <div class="flex items-center" x-data="{ momentRating: version.reviews_avg }">
                                    <x-rating></x-rating>

                                    <a :href="'/asic-miners/' + version.brand_slug + '/' + version.model_slug + '/reviews'"
                                        class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                        <span x-text="version.reviews_count"></span>
                                        {{ __('reviews') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mt-5 space-y-1 sm:space-y-2">
                                <div class="text-xxs xs:text-xs text-slate-600 dark:text-slate-300 flex items-end">
                                    {{ __('Algorithm') }}:<span class="dots mx-2"></span><span
                                        class="text-slate-900 dark:text-slate-100 font-bold"
                                        x-text="version.algorithm"></span>
                                </div>
                                <div class="text-xxs xs:text-xs text-slate-600 dark:text-slate-300 flex items-end">
                                    {{ __('Power') }}:<span class="dots mx-2"></span><span
                                        class="text-slate-900 dark:text-slate-100 font-bold"
                                        x-text="version.efficiency * version.hashrate"></span> W
                                </div>
                                <div class="text-xxs xs:text-xs text-slate-600 dark:text-slate-300 flex items-end">
                                    {{ __('The best price') }}:<span class="dots mx-2"></span><span
                                        class="text-slate-900 dark:text-slate-100 font-bold"
                                        x-text="version.price ? version.price + ' USDT' : '{{ __('No data') }}'"></span>
                                </div>
                            </div>
                            <template x-if="version.ads.length">
                                <a class="pt-3 sm:pt-4 lg:pt-6 w-fit"
                                    x-bind:href="version ? '/ads/miners?model=' + version.model_name : ' # '">
                                    <x-primary-button
                                        class="text-xxs sm:text-xs">{{ __('Find ads') }}</x-primary-button>
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </div>

            <div
                class="mt-6 md:mt-0 md:p-6 lg:p-9 xl:p-12 md:border-l border-slate-300 dark:border-slate-700 col-span-3">
                <div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
                    <h2 class="text-xs xs:text-sm text-slate-700 dark:text-slate-200">
                        {{ __('Calculation result') }}</h2>
                    <div class="flex cursor-pointer mx-3">
                        <button
                            :class="{
                                'bg-primary-gradient text-white': currency ==
                                    'RUB',
                                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                    'USDT'
                            }"
                            class="p-1 xs:p-1.5 rounded-l border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                            @click="currency = 'RUB'">RUB</button>
                        <button
                            :class="{
                                'bg-primary-gradient text-white': currency ==
                                    'USDT',
                                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                    'RUB'
                            }"
                            class="p-1 xs:p-1.5 rounded-r border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                            @click="currency = 'USDT'">USDT</button>
                    </div>
                </div>

                <template x-if="version !== null">
                    <div x-data="{
                        get dailyProfit() {
                            return (version.profits[profitNumber].profit * (100 - fee) * uptime / 10000) * count / (currency == 'RUB' ? {{ $rub }} : 1);
                        },
                        get dailyConsumption() {
                            return version.efficiency * version.hashrate / 1000 * tariff * 24 * uptime / 100 * count * (currency == 'USDT' ? {{ $rub }} : 1);
                        },
                        get dailyIncome() {
                            return this.dailyProfit - this.dailyConsumption;
                        },
                        get dailyIncomeUSDT() {
                            return (version.profits[profitNumber].profit * (100 - fee) * uptime / 10000 - version.efficiency * version.hashrate * tariff * {{ $rub }} * 24 * uptime / 100000) * count;
                        },
                        get total() { return this.dailyProfit + this.dailyConsumption },
                        get incPercent() { return this.total > 0 ? (this.dailyProfit / this.total) * 100 : 50 },
                        get expPercent() { return this.total > 0 ? (this.dailyConsumption / this.total) * 100 : 50 }
                    }">
                        <div class="space-y-4" x-data="{ view: 'month' }">
                            <div
                                class="flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full max-w-xs mx-auto mb-6">
                                <button @click="view = 'day'"
                                    :class="view === 'day' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                                    class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Day') }}</button>
                                <button @click="view = 'month'"
                                    :class="view === 'month' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                                    class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Month') }}</button>
                                <button @click="view = 'year'"
                                    :class="view === 'year' ? 'bg-white dark:bg-slate-800 shadow-md' : 'opacity-50'"
                                    class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Year') }}</button>
                            </div>

                            <div
                                class="bg-slate-50 dark:bg-slate-900/50 p-6 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                                <div class="text-center mb-6">
                                    <span class="text-slate-500 text-sm tracking-wide">{{ __('Net Profit') }}</span>
                                    <div class="text-4xl lg:text-5xl font-black text-slate-800 dark:text-slate-200 mt-1"
                                        x-text="view === 'day' ? Math.round(dailyIncome * 100)/100 : (view === 'month' ? Math.round(dailyIncome*30*100)/100 : Math.round(dailyIncome*365*100)/100)">
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between text-xs font-bold uppercase italic">
                                        <span class="text-emerald-500">{{ __('Income') }}</span>
                                        <span class="text-rose-500">{{ __('Expense') }}</span>
                                    </div>
                                    <div
                                        class="mt-2 h-2 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden flex">
                                        <div class="h-full bg-emerald-400 transition-all duration-500"
                                            :style="`width: ${incPercent}%`"></div>
                                        <div class="h-full bg-rose-400 transition-all duration-500"
                                            :style="`width: ${expPercent}%`"></div>
                                    </div>
                                    <div class="mt-3 flex justify-between text-sm sm:text-base lg:text-lg font-black text-slate-800 dark:text-slate-200">
                                        <span
                                            x-text="view === 'day' ? Math.round(calculateProfitCAGR(dailyProfit, 1, difficultyGrowth)*100)/100 : (view === 'month' ? Math.round(calculateProfitCAGR(dailyProfit, 30, difficultyGrowth)*100)/100 : Math.round(calculateProfitCAGR(dailyProfit, 365, difficultyGrowth)*100)/100)"></span>
                                        <span
                                            x-text="view === 'day' ? Math.round(dailyConsumption*100)/100 : (view === 'month' ? Math.round(dailyConsumption*30*100)/100 : Math.round(dailyConsumption*365*100)/100)"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 mt-6 sm:mt-7 lg:mt-8">
                            {{ __('Payback') }}:
                            <span class="text-slate-900 dark:text-slate-100 font-bold"
                                x-text="version.price ? dailyIncomeUSDT > 0 ? Math.round(version.price / dailyIncomeUSDT) + ' {{ __('Days') }}' : '∞' : '{{ __('No data') }}'"></span>
                        </div>

                        <div class="md:hidden">
                            <template x-if="version !== null">
                                <div class="mt-6 sm:mt-8 lg:mt-10">
                                    <div class="mt-6">
                                        <h2 class="sr-only">{{ __('Reviews') }}</h2>
                                        <div class="flex items-center" x-data="{ momentRating: version.reviews_avg }">
                                            <x-rating></x-rating>

                                            <a :href="'/asic-miners/' + version.brand_slug + '/' + version.model_slug + '/reviews'"
                                                class="ml-3 text-sm text-indigo-600 hover:text-indigo-500">
                                                <span x-text="version.reviews_count"></span>
                                                {{ __('reviews') }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-3 xs:mt-4 sm:mt-5 space-y-1 sm:space-y-2">
                                        <div
                                            class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 flex items-end">
                                            {{ __('Algorithm') }}:<span class="dots mx-2"></span><span
                                                class="text-slate-900 dark:text-slate-100 font-bold"
                                                x-text="version.algorithm"></span>
                                        </div>
                                        <div
                                            class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 flex items-end">
                                            {{ __('Power') }}:<span class="dots mx-2"></span><span
                                                class="text-slate-900 dark:text-slate-100 font-bold"
                                                x-text="version.efficiency * version.hashrate"></span> W
                                        </div>
                                        <div
                                            class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 flex items-end">
                                            {{ __('The best price') }}:<span class="dots mx-2"></span><span
                                                class="text-slate-900 dark:text-slate-100 font-bold"
                                                x-text="version.price ? version.price + ' USDT' : '{{ __('No data') }}'"></span>
                                        </div>
                                    </div>
                                    <template x-if="version.ads.length">
                                        <a class="pt-3 xs:pt-4 sm:pt-5 lg:pt-6 w-fit"
                                            x-bind:href="version ? '/ads/miners?model=' + version.model_name : ' # '">
                                            <x-primary-button
                                                class="text-xxs xs:text-xs">{{ __('Find ads') }}</x-primary-button>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <p class="text-xs xs:text-sm text-slate-700 dark:text-slate-200 mt-6 sm:mt-7 lg:mt-8">
                            {{ __('Coins per day') }}</p>

                        <template x-for="(profit, i) in version.profits" :key="'profit_' + i">
                            <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer"
                                @click="profitNumber = i, fee = version.profits[i].coins[0].fee">
                                <div>
                                    <label class="flex items-center">
                                        <input type="radio" name="profitNumber" :value="i"
                                            :aria-label="'{{ __('Change calculation to') }}' + ' ' + profit.coins[0].name"
                                            :checked="profitNumber == i"
                                            class="mr-2 w-3 h-3 sm:w-4 sm:h-4 text-blue-600 bg-slate-100 border-slate-300 focus:ring-0 dark:bg-slate-800 dark:border-slate-700 cursor-pointer">
                                    </label>
                                </div>
                                <template x-for="coin in profit.coins" :key="coin.abbreviation">
                                    <div>
                                        <div class="flex items-center">
                                            <img :src="'/storage/coins/' + coin.abbreviation + '.webp'"
                                                :alt="coin.name" class="w-3 xs:w-4 sm:w-5 mr-1 xs:mr-2">
                                            <div>
                                                <div class="text-xxs xs:text-xs text-slate-600 dark:text-slate-300"
                                                    x-text="coin.abbreviation">
                                                </div>
                                                <div class="text-xxs xs:text-xs text-slate-500 dark:text-slate-400"
                                                    x-text="coin.name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xxs xs:text-xs text-slate-700 dark:text-slate-200 font-bold mt-1"
                                            x-text="version ? Math.round(version.hashrate * coin.profit * version.coef * 100000000) / 100000000 : 0">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>

                        <a class="block mt-6 xl:mt-8"
                            x-bind:href="version ? ('/asic-miners/' + version.brand_slug + '/' + version.model_slug) : '#'">
                            <x-secondary-button>{{ __('More details about miner') }}</x-secondary-button>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                {{ __('Best value offers') }} {{ $selModel->name }}
            </h2>
        </div>

        <div>
            @include('home.components.carousel', [
                'items' => $ads,
                'blade' => 'ad.components.card',
                'model' => 'ad',
                'bigWrapper' => true,
            ])
        </div>
    </section>
</div>
