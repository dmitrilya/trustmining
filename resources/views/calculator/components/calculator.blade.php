@props(['blocks' => ['additional-params', 'coins', 'characteristics', 'currency'], 'widjet' => false])

<div class="min-h-[990px] md:min-h-[660px]">
    <meta itemprop="name"
        content="{{ __('Income calculator') }} {{ $selModel['b'] }} {{ $selModel['n'] }} {{ $selVersion['h'] }}{{ $selVersion['m'] }}" />
    <meta itemprop="description"
        content="{{ __('Calculate revenue, expenses, profit, and ROI for an ASIC miner') }} {{ $selModel['b'] }} {{ $selModel['n'] }} {{ $selVersion['h'] }}{{ $selVersion['m'] }} {{ __('in a convenient mining calculator') }}" />

    <div itemprop="object" itemscope itemtype="https://schema.org/Product"
        class="md:grid grid-cols-5 gap-6 lg:gap-9 xl:gap-12 md:p-6 lg:p-9 xl:p-12" x-data="{
            currency: 'RUB',
            tariff: 5,
            version: {
                ...{{ collect($selVersion) }},
                n: '{{ $selModel['n'] }}',
                ns: '{{ $selModel['s'] }}',
                b: '{{ $selModel['b'] }}',
                bs: '{{ $selModel['bs'] }}',
                r: {{ $selModel['r'] }},
                ra: @json($selModel['ra'])
            },
            profitNumber: 0,
            algorithms: {{ $algorithms }},
            fee: {{ $fee }},
            count: 1,
            uptime: 99.7,
            tax: 0,
            difficultyGrowth: 0,
            get profit() {
                return this.algorithms[this.version.a].p[this.profitNumber].p * this.version.h * this.version.c;
            },
            get dailyIncome() {
                return (this.profit * (100 - this.fee) * this.uptime / 10000) * this.count / (this.currency == 'RUB' ? {{ $rub }} : 1);
            },
            get dailyConsumption() {
                return this.version.e * this.version.h / 1000 * this.tariff * 24 * this.uptime / 100 * this.count * (this.currency == 'USDT' ? {{ $rub }} : 1);
            },
            get dailyProfit() {
                return this.dailyIncome - this.dailyConsumption;
            },
            get dailyProfitUSDT() {
                return (this.profit * (100 - this.fee) * this.uptime / 10000 - this.version.e * this.version.h * this.tariff * {{ $rub }} * 24 * this.uptime / 100000) * this.count;
            },
            get total() { return this.dailyIncome + this.dailyConsumption },
            get incPercent() { return this.total > 0 ? (this.dailyIncome / this.total) * 100 : 50 },
            get expPercent() { return this.total > 0 ? (this.dailyConsumption / this.total) * 100 : 50 },
            get momentRating() { return this.version.ra }
        }">
        <div class="col-span-2">
            @include('calculator.components.schema')

            @include('calculator.components.selectversion')

            @include('calculator.components.expenses')

            @if (in_array('characteristics', $blocks))
                <div class="hidden md:block">
                    <template x-if="version !== null">
                        <div class="mt-8 lg:mt-10">
                            @if (!$widjet)
                                <div class="mt-6">
                                    <h2 class="sr-only">{{ __('Reviews') }}</h2>
                                    <div class="flex items-center">
                                        <x-rating></x-rating>

                                        <a :href="'/asic-miners/' + version.bs + '/' + version.ns + '/reviews'"
                                            class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">
                                            <span x-text="version.r"></span>
                                            <span
                                                x-text="window.pluralize(version.r, '{{ trans_choice('navigation.reviews', 1) }}', '{{ trans_choice('navigation.reviews', 2) }}', '{{ trans_choice('navigation.reviews', 5) }}')"></span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-5 space-y-2" style="min-height: 152px">
                                <x-characteristics>
                                    <x-characteristic name="Algorithm" x-value="version.algorithm" />
                                    <x-characteristic name="Efficiency" x-value="version.e + ' j/' + version.m" />
                                    <x-characteristic name="Power" x-value="version.e * version.h" />
                                    @if (!$widjet)
                                        <x-characteristic name="The best price"
                                            x-value="version.p ? version.p + ' USDT' : '{{ __('No data') }}'" />
                                    @endif
                                    <x-characteristic name="USDTRUB" :value="round(1 / $rub, 2)" />
                                </x-characteristics>
                                @if (!$widjet)
                                    <a class="block mt-6 ml-auto w-fit text-sm text-indigo-500 hover:text-indigo-600"
                                        x-bind:href="version ?
                                            `/asic-miners/${version.bs}/${version.ns}/${version.h}${version.m}` : '#'">
                                        {{ __('All characteristics') }}
                                    </a>
                                @endif
                            </div>
                            @if (!$widjet)
                                <template x-if="version.ac">
                                    <a class="mt-4 lg:mt-6 w-fit"
                                        x-bind:href="version ? '/ads/miners?model=' + version.ns : ' # '">
                                        <x-primary-button
                                            class="text-xxs sm:text-xs">{{ __('Find ads') }}</x-primary-button>
                                    </a>
                                </template>
                            @endif
                        </div>
                    </template>
                </div>
            @endif
        </div>

        <div
            class="mt-4 md:mt-0 md:border-l border-slate-300 dark:border-slate-700 md:pl-6 lg:pl-9 xl:pl-12 col-span-3">
            @if (in_array('currency', $blocks))
                <div class="flex items-center justify-between mb-6 sm:mb-7 lg:mb-8">
                    <h2 class="text-xs xs:text-sm text-slate-700 dark:text-slate-200">
                        {{ __('Profit calculation') }}</h2>
                    <div class="flex cursor-pointer mx-3">
                        <button
                            :class="{
                                'bg-primary-gradient text-white': currency ==
                                    'RUB',
                                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                    'USDT'
                            }"
                            class="p-1 xs:p-1.5 rounded-l-md border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                            @click="currency = 'RUB'">RUB</button>
                        <button
                            :class="{
                                'bg-primary-gradient text-white': currency ==
                                    'USDT',
                                'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                    'RUB'
                            }"
                            class="p-1 xs:p-1.5 rounded-r-md border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                            @click="currency = 'USDT'">USDT</button>
                    </div>
                </div>
            @endif

            <template x-if="version !== null">
                <div>
                    <div x-data="{ view: 'month' }" style="min-height: 228px" class="space-y-2 sm:space-y-4">
                        <div class="flex p-1 bg-slate-50 dark:bg-slate-900 rounded-xl w-full max-w-xs mx-auto">
                            <button @click="view = 'day'"
                                :class="view === 'day' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
                                class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Day') }}</button>
                            <button @click="view = 'month'"
                                :class="view === 'month' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
                                class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Month') }}</button>
                            <button @click="view = 'year'"
                                :class="view === 'year' ? 'bg-white dark:bg-slate-800 shadow-lg' : 'opacity-80'"
                                class="flex-1 py-1.5 text-xs text-slate-700 dark:text-slate-300 font-bold rounded-lg transition-all">{{ __('Year') }}</button>
                        </div>

                        <div
                            class="bg-slate-50 dark:bg-slate-900/50 p-4 sm:p-6 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700">
                            <div class="text-center mb-6">
                                <span class="text-slate-500 text-sm tracking-wide">{{ __('Net Profit') }}</span>
                                <div class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-800 dark:text-slate-200 mt-1"
                                    x-text="view === 'day' ? Math.round(dailyProfit * 100)/100 : (view === 'month' ? Math.round(dailyProfit*30*100)/100 : Math.round(dailyProfit*365*100)/100)">
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between text-xs font-extrabold uppercase">
                                    <span class="text-emerald-500">{{ __('Income') }}</span>
                                    <span class="text-red-700 dark:text-red-500">{{ __('Expense') }}</span>
                                </div>
                                <div
                                    class="mt-2 h-1 sm:h-2 w-full bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden flex">
                                    <div class="h-full bg-emerald-500 transition-all duration-500"
                                        :style="`width: ${incPercent}%`"></div>
                                    <div class="h-full bg-red-600 transition-all duration-500"
                                        :style="`width: ${expPercent}%`"></div>
                                </div>
                                <div
                                    class="mt-3 flex justify-between text-sm sm:text-base lg:text-lg font-black text-slate-800 dark:text-slate-200">
                                    <span
                                        x-text="view === 'day' ? Math.round(calculateProfitCAGR(dailyIncome, 1, difficultyGrowth)*100)/100 : (view === 'month' ? Math.round(calculateProfitCAGR(dailyIncome, 30, difficultyGrowth)*100)/100 : Math.round(calculateProfitCAGR(dailyIncome, 365, difficultyGrowth)*100)/100)"></span>
                                    <span
                                        x-text="view === 'day' ? Math.round(dailyConsumption*100)/100 : (view === 'month' ? Math.round(dailyConsumption*30*100)/100 : Math.round(dailyConsumption*365*100)/100)"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (!$widjet)
                        <div class="text-xxs text-slate-500 mt-3">
                            *{{ __('The data is current at the time of calculation. The cryptocurrency market is volatile, and figures are subject to change') }}
                        </div>
                        <div class="flex text-xs xs:text-sm text-slate-600 dark:text-slate-400 mt-6 sm:mt-7 lg:mt-8">
                            <h3>{{ __('Payback period') }}</h3>:
                            <span class="ml-1 text-slate-900 dark:text-slate-100 font-bold"
                                x-text="version.p ? dailyProfitUSDT > 0 ? Math.round(version.p / dailyProfitUSDT) + ' {{ __('Days') }}' : '∞' : '{{ __('No data') }}'"></span>
                        </div>
                        <div class="text-xxs text-slate-500 mt-2">
                            *{{ __('The best offer at the moment is used for payback calculation') }}
                        </div>
                    @endif

                    @if (in_array('characteristics', $blocks))
                        <div class="md:hidden">
                            <template x-if="version !== null">
                                <div class="mt-6 sm:mt-8">
                                    @if (!$widjet)
                                        <div class="mt-6">
                                            <h2 class="sr-only">{{ __('Reviews') }}</h2>
                                            <div class="flex items-center">
                                                <x-rating></x-rating>

                                                <a :href="`/asic-miners/${version.bs}/${version.ns}/reviews`"
                                                    class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">
                                                    <span x-text="version.r"></span>
                                                    <span
                                                        x-text="window.pluralize(version.r, '{{ trans_choice('navigation.reviews', 1) }}', '{{ trans_choice('navigation.reviews', 2) }}', '{{ trans_choice('navigation.reviews', 5) }}')"></span>
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-3 xs:mt-4 sm:mt-5 space-y-1 sm:space-y-1.5"
                                        style="min-height: 120px">
                                        <x-characteristics>
                                            <x-characteristic name="Algorithm" x-value="algorithms[version.a].n" />
                                            <x-characteristic name="Efficiency"
                                                x-value="version.e + ' j/' + version.m" />
                                            <x-characteristic name="Power" x-value="version.e * version.h" />
                                            @if (!$widjet)
                                                <x-characteristic name="The best price"
                                                    x-value="version.p ? version.p + ' USDT' : '{{ __('No data') }}'" />
                                            @endif
                                            <x-characteristic name="USDTRUB" :value="round(1 / $rub, 2)" />
                                        </x-characteristics>
                                        @if (!$widjet)
                                            <a class="block mt-6 ml-auto w-fit text-xs xs:text-sm text-indigo-500 hover:text-indigo-600"
                                                x-bind:href="version ?
                                                    `/asic-miners/${version.bs}/${version.ns}/${version.h}${version.m}` :
                                                    '#'">
                                                {{ __('All characteristics') }}
                                            </a>
                                        @endif
                                    </div>

                                    @if (!$widjet)
                                        <template x-if="version.ac">
                                            <a class="mt-3 xs:mt-4 sm:mt-5 w-fit"
                                                x-bind:href="version ? '/ads/miners?model=' + version.ns : ' # '">
                                                <x-primary-button
                                                    class="text-xxs xs:text-xs">{{ __('Find ads') }}</x-primary-button>
                                            </a>
                                        </template>
                                    @endif
                                </div>
                            </template>
                        </div>
                    @endif

                    @if (in_array('coins', $blocks))
                        <h2 class="text-xs xs:text-sm text-slate-700 dark:text-slate-200 mt-6 sm:mt-7 lg:mt-8">
                            {{ __('How many coins does it mine per day') }}</h2>

                        <template x-for="(profit, i) in algorithms[version?.a].p" :key="'profit_' + i">
                            <div class="flex flex-wrap gap-y-2 items-center space-x-2 mt-3 sm:mt-5 cursor-pointer"
                                @click="profitNumber = i, fee = profit.c[0].f;">
                                <x-radio name="profitNumber" ::value="i" ::checked="profitNumber == i" ::aria-label="`{{ __('Change calculation to') }} ${profit.c[0].n}`" />

                                <template x-for="coin in profit.c" :key="coin.a">
                                    <div>
                                        <div class="flex items-center">
                                            <img :src="`/storage/coins/${coin.a}.webp`"
                                                :alt="'{{ __('Calculator') }} ' + coin.n"
                                                class="w-5 xs:w-6 mr-1 xs:mr-2">
                                            <div>
                                                <div class="text-xs xs:text-sm text-slate-600 dark:text-slate-400"
                                                    x-text="coin.a">
                                                </div>
                                                <div class="text-xxs xs:text-xs text-slate-500" x-text="coin.n">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-xxs xxs:text-xs text-slate-800 dark:text-slate-200 font-bold mt-0.5 xs:mt-1"
                                            x-text="version ? Math.round(version.h * coin.p * version.c * 100000000) / 100000000 : 0">
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    @endif
                </div>
            </template>
        </div>
    </div>
</div>
