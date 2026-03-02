<x-app-layout title="Доходность асиков на сегодня: Рейтинг самых прибыльных ASIC-майнеров 2026"
    description="Актуальный рейтинг самых прибыльных ASIC-майнеров на 2026 год. Таблица доходности и окупаемости асиков для майнинга Bitcoin (BTC) и других валют. Сравнение ТОП-моделей.">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('The most profitable ASICs') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-4 sm:space-y-6" x-data="{
        tariff: 5,
        currency: 'RUB',
        rubRate: {{ $rub }},
        models: {{ $models }},
        getNetProfit(model) {
            let profit = model.profit / (this.currency === 'RUB' ? this.rubRate : 1);
            let cost = (model.power * this.tariff * (this.currency === 'RUB' ? 1 : this.rubRate) * 24) / 1000;
            return Math.round((profit - cost) * 100) / 100;
        },
        get sortedModels() {
            return this.models
                .map(m => ({ ...m, netProfit: this.getNetProfit(m) }))
                .sort((a, b) => b.netProfit - a.netProfit)
                .slice(0, 15);
        }
    }">
        <div class="flex justify-center">
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-full p-0.5 space-x-2 flex">
                <div class="relative z-0 group">
                    <input id="tariff" type="text" :value="tariff" aria-label="{{ __('Tariff') }}"
                        class="py-1 px-3 block w-28 rounded-full text-sm text-slate-950 bg-slate-50 dark:bg-slate-950 dark:text-slate-200 border ring-0 border-slate-300 dark:border-slate-700 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-500"
                        @input="tariff = filterDouble($el, 0, 20, 2);$el.value = tariff" />
                    <label for="tariff"
                        class="z-10 flex items-center absolute text-sm text-slate-600 dark:text-slate-300 duration-300 right-0 top-1/2 -translate-y-1/2 scale-75 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('rub./kW') }}
                    </label>
                </div>

                <div class="flex cursor-pointer ml-2 sm:ml-3">
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'RUB',
                            'bg-slate-100 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                'USDT'
                        }"
                        class="px-2 rounded-l-full border border-r-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                        @click="currency = 'RUB'">RUB</button>
                    <button
                        :class="{
                            'bg-primary-gradient text-white': currency ==
                                'USDT',
                            'bg-slate-50 hover:bg-slate-200 text-slate-800 dark:bg-slate-950 dark:hover:bg-slate-900 dark:text-slate-100': currency ==
                                'RUB'
                        }"
                        class="px-2 rounded-r-full border border-l-0 border-slate-300 dark:border-slate-700 text-xxs font-semibold"
                        @click="currency = 'USDT'">USDT</button>
                </div>
            </div>
        </div>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 rounded-xl shadow-lg shadow-logo-color p-2 sm:p-4 md:p-6 lg:p-8 relative divide-y divide-slate-300 dark:divide-slate-700">
            <template x-for="(model, index) in sortedModels" :key="model.url_name">
                <a href="`/database/${model.brand}/${model.url_name}`"
                    class="py-2 group rounded-md grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-8 xl:grid-cols-9 gap-1 xs:gap-2 items-center">
                    <h2
                        class="relative font-semibold text-slate-600 dark:text-slate-400 text-xxs xs:text-xs sm:text-sm group-hover:text-slate-900 dark:group-hover:text-slate-200 col-span-2">
                        <div x-show="index < 3"
                            class="absolute -left-2 sm:-left-3 md:-left-4 lg:-left-5 -top-2 sm:-top-2 md:-top-3 lg:-top-4 size-3 sm:size-4 md:size-5 lg:size-6">
                            <img :src="index === 0 ? '/img/gold.webp' : (index === 1 ? '/img/silver.webp' : '/img/bronze.webp')"
                                alt="medal">
                        </div>

                        <span x-text="`${model.name} ${model.hashrate}${model.measurement}/s`"></span>
                    </h2>
                    <div class="hidden sm:block text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.power * 10) / 10 + ' ' + '{{ __('W') }}'"></div>
                    <div class="hidden lg:block text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="model.algorithm"></div>
                    <div class="hidden xl:block text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="model.original_efficiency + 'j/' + model.original_measurement"></div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.profit / (currency === 'RUB' ? rubRate : 1) * 100) / 100">
                    </div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.power * tariff * (currency === 'RUB' ? 1 : rubRate) * 24 / 10) / 100">
                    </div>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs xs:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="model.netProfit">
                    </div>
                    <div class="hidden md:block pl-1.5 sm:pl-2">
                        <template x-for="coin in model.coins">
                            <img class="min-w-3 h-3 sm:min-w-4 sm:h-4 -ml-1.5 sm:-ml-2 inline"
                                :src="'/storage/coins/' + coin + '.webp'" :alt="coin">
                        </template>
                    </div>
                </a>
            </template>
        </div>
    </div>
</x-app-layout>
