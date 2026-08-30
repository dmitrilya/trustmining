<x-app-layout :title="$title" :description="$description">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">{{ $header }}</h1>
    </x-slot>

    <div class="max-w-8xl mx-auto px-2 py-4 sm:p-4 lg:p-6 space-y-2 sm:space-y-4" x-data="{
        tariff: 5,
        currency: 'RUB',
        rub: {{ $rub }},
        models: {{ $models }},
        algos: {{ $algorithms }},
        coolingTypes: {{ collect(array_column(\App\Enums\CoolingType::cases(), 'name'))->map(fn($type) => __($type)) }},
        sortedModels: [],
        init() {
            this.$watch('tariff, currency', () => this.updateModels());
    
            this.updateModels();
        },
        getNetProfit(model) {
            let cost = (model.v.h * model.v.e * this.tariff * this.rub * 24) / 1000;
            return Math.round((this.algos[model.a].p[0].p * model.v.h * model.v.c - cost) * 100) / 100;
        },
        getNetProfitCurrency(model) {
            let profit = this.algos[model.a].p[0].p * model.v.h * model.v.c / (this.currency === 'RUB' ? this.rub : 1);
            let cost = (model.v.h * model.v.e * this.tariff * (this.currency === 'RUB' ? 1 : this.rub) * 24) / 1000;
            return Math.round((profit - cost) * 100) / 100;
        },
        getPayback(model) {
            const netProfit = this.getNetProfit(model);
            return model.v.p && netProfit > 0 ? Math.round(model.v.p / netProfit) : 99999;
        },
        updateModels() {
            this.sortedModels = this.models
                .map(m => ({
                    ...m,
                    netProfit: this.getNetProfit(m),
                    netProfitCurrency: this.getNetProfitCurrency(m),
                    payback: this.getPayback(m)
                }))
                .sort((a, b) => '{{ $type }}' == 'profit' ? b.netProfit - a.netProfit : a.payback - b.payback)
                .slice(0, 15);
        }
    }">
        <x-breadcrumbs.breadcrumbs>
            <x-breadcrumbs.breadcrumb position="1" :href="route('ratings')" :name="__('meta.rating.breadcrumb')" />
            <x-breadcrumbs.breadcrumb position="2" :href="route('rating.asics')" :name="__('meta.rating.asics.breadcrumb')" />
            @if (!$filterType)
                <x-breadcrumbs.breadcrumb position="3" :name="__('meta.rating.asics.types.' . $type . '.breadcrumb')" />
            @else
                <x-breadcrumbs.breadcrumb position="3" :href="route('rating.asics.show', ['type' => $type])" :name="__('meta.rating.asics.types.' . $type . '.breadcrumb')" />
                <x-breadcrumbs.breadcrumb position="4" :name="$filterType == 'cooling'
                    ? __('meta.rating.asics.filters.cooling.' . $filterValue . '.breadcrumb')
                    : __('meta.rating.asics.filters.' . $filterType . '.breadcrumb', ['filter_value' => $filterValue])" />
            @endif
        </x-breadcrumbs.breadcrumbs>

        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow-lg shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6">
            <h2 class="text-xxs sm:text-xs font-semibold tracking-wider text-slate-600 dark:text-slate-400 uppercase block mb-1.5">
                {{ $filterType ? __('meta.rating.asics.filters.best', ['prefix' => __("meta.rating.asics.types.$type.best_prefix")]) : __("meta.rating.asics.types.$type.best") }}
            </h2>

            <div class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
                <div class="md:col-span-2 md:border-r border-slate-300 dark:border-slate-700 md:pr-8">
                    <h3 class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl" x-text="sortedModels[0].n"></h3>

                    <div class="md:col-span-2 md:col-start-1 mt-4 md:mt-8">
                        <div>
                            <x-characteristics.characteristics class="lg:grid grid-cols-2 gap-x-4 my-4 md:my-6">
                                <x-characteristics.characteristic name="Hashrate" xValue="sortedModels[0].v.h + ' ' + sortedModels[0].v.m + '/s'" />
                                <x-characteristics.characteristic name="Efficiency" xValue="sortedModels[0].v.e + ' j/' + sortedModels[0].v.m" />
                                <x-characteristics.characteristic name="Power" xValue="Math.round(sortedModels[0].v.e * sortedModels[0].v.h) + ' {{ __('W') }}'" />
                                <template x-if="sortedModels[0].v.p">
                                    <x-characteristics.characteristic name="The best price" xValue="sortedModels[0].v.p + ' USDT'" />
                                </template>
                            </x-characteristics.characteristics>

                            <div class="mt-2 sm:mt-3 grid grid-cols-1 xs:grid-cols-2 gap-2 sm:gap-4">
                                <div class="p-2 sm:p-4 lg:p-6 rounded-xl relative z-0 bg-slate-900 dark:bg-slate-800 shadow-lg overflow-hidden">
                                    <div class="relative z-10">
                                        <span class="text-slate-400 text-xxs xxs:text-xs font-bold uppercase tracking-widest">{{ __('Profit per day') }}</span>
                                        <div class="mt-2 flex items-baseline gap-2">
                                            <span class="text-xl sm:text-3xl font-black"
                                                :class="sortedModels[0].netProfit > 1 ? 'text-emerald-500' : 'text-red-500'"
                                                x-text="sortedModels[0].netProfit"></span>
                                            <span class="font-bold" :class="sortedModels[0].netProfit > 1 ? 'text-emerald-500' : 'text-red-500/50'">USDT</span>
                                        </div>
                                        <p class="text-slate-400 text-xs mt-1 sm:mt-2"
                                            x-text="'≈' + Math.round(sortedModels[0].netProfit / rub * 100) / 100 + '₽'"></p>
                                    </div>
                                    <div class="absolute bottom-0 left-0 right-0 h-16 opacity-25">
                                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                            <path d="M0 100 C 20 80, 40 90, 50 60 C 60 30, 80 40, 100 0 V 100 H 0 Z" fill="url(#grad)" />
                                            <defs>
                                                <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
                                                    <stop offset="0%" style="stop-color:rgb(16, 185, 129);stop-opacity:1" />ы
                                                    <stop offset="100%" style="stop-color:rgb(16, 185, 129);stop-opacity:0" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                    </div>
                                </div>

                                <div
                                    class="p-2 sm:p-4 lg:p-6 rounded-xl bg-white dark:bg-slate-300 border border-slate-300 dark:border-slate-700 shadow overflow-hidden">
                                    <span class="text-slate-500 text-xxs xxs:text-xs font-bold uppercase tracking-widest">{{ __('Payback') }}</span>
                                    <div class="mt-2">
                                        <span class="text-xl sm:text-3xl font-black text-slate-800"
                                            x-text="sortedModels[0].payback != 99999 ? sortedModels[0].v.p ? Math.round(sortedModels[0].payback) : '{{ __('No data') }}' : '∞'"></span>
                                        <template x-if="sortedModels[0].payback != 99999">
                                            <span class="text-slate-500 font-bold text-lg">{{ __('d') }}.</span>
                                        </template>
                                    </div>
                                    <template x-if="sortedModels[0].v.p">
                                        <div class="mt-1 sm:mt-1.5 w-fit px-1 xs:px-2 py-0.5 rounded text-xxs xxs:text-xs font-bold uppercase tracking-tighter"
                                            :class="{
                                                'bg-rose-500/10 text-rose-500': sortedModels[0].payback > 1460 || sortedModels[0].payback == 99999,
                                                'bg-amber-500/10 text-amber-500': sortedModels[0].payback > 730 && sortedModels[0].payback <= 1460,
                                                'bg-emerald-500/10 text-emerald-500': sortedModels[0].payback <= 730,
                                            }">
                                            <span
                                                x-text="sortedModels[0].payback != 99999 ? sortedModels[0].payback <= 730 ? '{{ __('Top payback') }}' : (sortedModels[0].payback <= 1460 ? '{{ __('Normal') }}' : '{{ __('Long payback period') }}') : '{{ __('WOW') }}'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="sm:flex flex-row-reverse mt-6 md:mt-8">
                                <div class="w-full sm:w-fit mt-2 sm:mt-0">
                                    <a class="block w-full" :href="'/calculator/' + sortedModels[0].s + '/' + sortedModels[0].v.h">
                                        <x-buttons.secondary-button
                                            class="bg-secondary-gradient dark:text-slate-800 w-full">{{ __('Income calculator') }}</x-buttons.secondary-button>
                                    </a>
                                </div>
                            </div>

                            <h2 class="text-sm text-slate-800 dark:text-slate-200 mt-8 mb-3">
                                {{ __('How many coins does it mine per day') }}
                            </h2>

                            <div class="grid gap-2 grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                                <template x-for="coin in algos[sortedModels[0].a].p.flatMap(p => p.c).filter(c => c.p > 0)" :key="coin.a">
                                    <div>
                                        <div class="flex items-center">
                                            <img :alt="coin.n + ' icon'" class="w-5 xs:w-6 mr-1 xs:mr-2" :src="'/storage/coins/' + coin.a + '.webp'" />
                                            <div>
                                                <div class="text-xs xxs:text-sm text-slate-600 dark:text-slate-400" x-text="coin.a"></div>
                                                <div class="text-xxs xxs:text-xs text-slate-500" x-text="coin.n"></div>
                                            </div>
                                        </div>
                                        <div class="text-xxs xxs:text-xs text-slate-800 dark:text-slate-200 font-bold mt-0.5 xs:mt-1"
                                            x-text="Math.round(sortedModels[0].v.h * coin.p * 100000000) / 100000000"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 md:mt-0">
                    <h4 class="sr-only">Информация</h4>

                    <div class="w-full rounded-lg overflow-hidden mb-4 sm:mb-6">
                        <img itemprop="image" class="w-full object-cover" :src="'/storage/asic-miners/' + sortedModels[0].s + '_380.webp'"
                            :alt="sortedModels[0].b + ' ' + sortedModels[0].n">
                    </div>

                    <div class="hidden md:block">
                        <x-characteristics.characteristics>
                            <x-characteristics.characteristic name="Manufacturer" xValue="sortedModels[0].b" />
                            <x-characteristics.characteristic name="Algorithm" xValue="algos[sortedModels[0].a].n" />
                            <x-characteristics.characteristic name="Cooling" xValue="coolingTypes[sortedModels[0].c]" />
                        </x-characteristics.characteristics>
                    </div>

                    <div class="flex flex-col mt-4 sm:mt-6 lg:mt-8">
                        <a :href="'/ads/miners?model=' + sortedModels[0].s + '&asic_version_id' + sortedModels[0].v.i">
                            <x-buttons.primary-button class="w-full mt-2">{{ __('Buy') }}</x-buttons.primary-button>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-full p-0.5 space-x-2 flex">
                <div class="relative z-0 group">
                    <input id="tariff" type="text" :value="tariff" aria-label="{{ __('Tariff') }}"
                        class="py-1 px-3 block w-28 rounded-full text-sm text-slate-800 bg-slate-50 dark:bg-slate-950 dark:text-slate-200 border ring-0 border-slate-300 dark:border-slate-700 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-500"
                        @input="tariff = filterDouble($el, 0, 20, 2);$el.value = tariff" />
                    <label for="tariff"
                        class="z-10 flex items-center absolute text-sm text-slate-600 dark:text-slate-400 duration-300 right-0 top-1/2 -translate-y-1/2 scale-75 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('rub./kW') }}
                    </label>
                </div>

                <div class="flex cursor-pointer ml-2 sm:ml-3">
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'RUB',
                            'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-200': currency ==
                                'USDT'
                        }"
                        class="px-2 rounded-l-full border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                        @click="currency = 'RUB'">RUB</button>
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'USDT',
                            'bg-slate-50 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-200': currency ==
                                'RUB'
                        }"
                        class="px-2 rounded-r-full border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                        @click="currency = 'USDT'">USDT</button>
                </div>
            </div>
        </div>

        <div
            class="min-h-[479px] sm:min-h-[563px] bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl shadow-lg shadow-logo-color p-2 sm:p-4 lg:p-6 relative divide-y divide-slate-300 dark:divide-slate-700">
            <div
                class="py-2 xs:pb-3 sm:pb-4 group rounded-md grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-8 xl:grid-cols-10 xxl:grid-cols-11 gap-1 xs:gap-2 items-center font-bold text-slate-500 text-xxs sm:text-xs">
                <p class="col-span-2">{{ __('Model') }}</p>
                <p class="hidden xl:block">{{ __('Power') }}</p>
                <p class="hidden xl:block">{{ __('Algorithm') }}</p>
                <p class="hidden xxl:block">{{ __('Eff.') }}</p>
                <p class="hidden md:block">{{ __('Income') }}</p>
                <p class="hidden sm:block">{{ __('Expense') }}</p>
                <p>{{ __('Min. price') }}</p>
                <p>{{ __('Profit') }}</p>
                <p>{{ __('Pback') }}</p>
                <p class="hidden lg:block">{{ __('Coins') }}</p>
            </div>
            <template x-for="(model, index) in sortedModels" :key="model.i">
                <a :href="`/asic-miners/${model.bs}/${model.s}`"
                    class="py-2 group rounded-md grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-8 xl:grid-cols-10 xxl:grid-cols-11 gap-1 xs:gap-2 items-center">
                    <h2
                        class="relative font-bold text-slate-600 dark:text-slate-400 text-xxs sm:text-xs sm:text-sm group-hover:text-slate-800 dark:group-hover:text-slate-200 col-span-2">
                        <div x-show="index < 3"
                            class="absolute -left-2 sm:-left-3 md:-left-4 lg:-left-5 -top-2 sm:-top-2 md:-top-3 lg:-top-4 w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 lg:w-6 lg:h-6">
                            <img :src="index === 0 ? '/img/gold.webp' : (index === 1 ? '/img/silver.webp' : '/img/bronze.webp')" alt="medal">
                        </div>

                        <span x-text="`${model.n} ${model.v.h}${model.v.m}/s`"></span>
                    </h2>
                    <div class="hidden xl:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.v.e * model.v.h * 10) / 10 + ' ' + '{{ __('W') }}'"></div>
                    <div class="hidden xl:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="algos[model.a].n"></div>
                    <div class="hidden xxl:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="model.v.e + 'j/' + model.v.m"></div>
                    <div class="hidden md:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="Math.round(algos[model.a].p[0].p * model.v.h * model.v.c / (currency === 'RUB' ? rub : 1) * 100) / 100">
                    </div>
                    <div class="hidden sm:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.v.e * model.v.h * tariff * (currency == 'RUB' ? 1 : rub) * 24 / 10) / 100">
                    </div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="model.v.p ? Math.round(model.v.p / (currency == 'USDT' ? 1 : rub) * 10) / 10 + ' ' + currency : '-'">
                    </div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="model.netProfitCurrency">
                    </div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-800 dark:group-hover:text-slate-200"
                        x-text="model.payback != 99999 ? model.payback + ' {{ __('days') }}' : '-'">
                    </div>
                    <div class="hidden lg:block pl-1.5 sm:pl-2">
                        <template x-for="coin in algos[model.a].p[0].c">
                            <img class="min-w-3 h-3 sm:min-w-4 sm:h-4 -ml-1.5 sm:-ml-2 inline" :src="'/storage/coins/' + coin.a + '.webp'"
                                :alt="coin.n + ' icon'">
                        </template>
                    </div>
                </a>
            </template>
        </div>

        <section>
            @include('rating.asics.components.filters')
        </section>

        <section class="mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                    {{ __('Offers') }}
                </h2>
            </div>

            <div>
                <x-carousel.carousel :items="$ads" blade="ad.components.card" model="ad" :big="true" />
            </div>
        </section>

        {{-- @include('profitable.components.faq') --}}
    </div>
</x-app-layout>
