<x-metrics-layout title="Сложность сети {{ $coin->name }}({{ $coin->abbreviation }}) сегодня: прогноз, онлайн график" :header="__('Network difficulty') . ' ' . __($coin->name)"
    active="network_difficulty" :coin="$coin"
    description="Актуальная сложность сети {{ $coin->name }}, онлайн-график, история изменений и прогноз следующего пересчёта. Данные обновляются в реальном времени">
    @vite(['resources/js/graph.js'])

    <x-breadcrumbs.breadcrumbs>
        <x-breadcrumbs.breadcrumb position="1" :href="route('metrics')" :name="__('Metrics')" />
        <x-breadcrumbs.breadcrumb position="2" :href="route('metrics.network')" :name="__('Cryptonetwork')" />
        <x-breadcrumbs.breadcrumb position="3" :name="__('Network difficulty') . ' ' . $coin->abbreviation" />
    </x-breadcrumbs.breadcrumbs>

    <div class="flex flex-wrap gap-2 sm:gap-3 mb-4 sm:mb-6">
        <a href="#"
            class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md bg-indigo-200 dark:bg-indigo-600 border-indigo-500 dark:border-indigo-700 text-indigo-500 dark:text-slate-200">
            {{ __('Difficulty') }}
        </a>
        @if ($coin->networkHashrates()->exists())
            <a href="{{ route('metrics.network.hashrate', ['coin' => strtolower(request()->route()->coin->name)]) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200">
                {{ __('Hashrate') }}
            </a>
        @endif
        @if ($coin->coinRates()->exists())
            <a href="{{ route('metrics.coin.rate', ['coin' => strtolower(request()->route()->coin->name)]) }}"
                class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 font-semibold text-xs lg:text-sm border rounded-md border-slate-300 dark:border-slate-700 hover:border-indigo-500 dark:hover:border-indigo-700 text-slate-600 dark:text-slate-400 group-hover:text-indigo-600 dark:group-hover:text-slate-200">
                {{ __('Rate') }}
            </a>
        @endif
    </div>

    <div x-data="{ period: '1y', items: [] }" x-init="axios.get('{{ route('metrics.network.get_difficulty', ['coin' => strtolower($coin->name)]) }}').then(r => {
        window.buildGraph(r.data.difficulties, period, 'graph', 'value');
        difficulties = [];
        const targetDate = new Date(Date.now() - 372 * 24 * 60 * 60 * 1000);
        for (const difficulty of r.data.difficulties.reverse()) {
            if (new Date(difficulty.date) > targetDate) difficulties.push(difficulty);
            else break;
        }
        items = difficulties.slice(0, difficulties.length - 1).filter((difficulty, i) => difficulty.value != difficulties[i + 1].value);
    })">
        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 lg:p-6">
            @include('metrics.network.difficulty.components.difficulty')
        </div>

        <div
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl mt-2 sm:mt-4 p-2 sm:p-4 lg:p-6">
            <h2 class="mb-4 lg:mb-6 text-lg sm:text-xl text-slate-800 dark:text-slate-200 font-extrabold">
                {{ __('History of changes') }}
            </h2>
            <div x-data="{ show: false }" class="w-full">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b border-indigo-600">
                            <th class="py-1.5 md:py-4 pr-4 text-left font-bold text-xs sm:text-sm text-slate-500">
                                {{ __('Date') }}
                            </th>
                            <th class="py-1.5 md:py-4 pr-4 text-left font-bold text-xs sm:text-sm text-slate-500">
                                {{ __('Network difficulty') }}
                            </th>
                            <th class="py-1.5 md:py-4 font-bold text-xs sm:text-sm text-right text-slate-500">
                                {{ __('Change') }}
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                        <template x-for="(item, i) in items.slice(0, items.length - 1)" :key="item.date">
                            <tr x-show="i < 5 || show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <td class="py-1.5 lg:py-2 pr-4 text-xxs xxs:text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200 whitespace-nowrap"
                                    x-text="new Date(item.date).toLocaleString(window.locale, {
                                        year: 'numeric',
                                        month: 'short',
                                        day: 'numeric',
                                    })">
                                </td>

                                <td class="py-1.5 lg:py-2 pr-4 text-xxs xxs:text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200"
                                    x-text="item.value">
                                </td>

                                <td class="py-1.5 lg:py-2 text-xxs xxs:text-xs xs:text-sm sm:text-base text-right whitespace-nowrap"
                                    :class="{
                                        'text-green-500': item.value > items[i + 1]?.value,
                                        'text-red-500': item.value < items[i + 1]?.value,
                                        'text-slate-800 dark:text-slate-200': item.value == items[i + 1]?.value
                                    }"
                                    x-text="items[i + 1] ? (item.value > items[i + 1].value ? '+' + Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%' : Math.round((item.value / items[i + 1].value - 1) * 10000) / 100 + '%') : '—'">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <template x-if="items.length > 5">
                    <button @click="show = !show"
                        class="mt-3 block w-fit ml-auto text-xs xs:text-sm text-indigo-500 hover:text-indigo-600 transition duration-300">
                        <span x-text="!show ? '{{ __('Show all') }}' : '{{ __('Hide') }}'"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <div
        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl mt-2 sm:mt-4 p-2 sm:p-4 lg:p-6">
        <h2 class="mb-2 lg:mb-4 text-lg sm:text-xl text-slate-800 dark:text-slate-200 font-extrabold">
            {{ __('Free alerts') }}
        </h2>

        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
            {{ __('Subscribe to notifications about current network difficulty and a forecast of the next change via Telegram, email, or browser. You can choose how often you want to receive notifications.') }}
        </p>

        <x-buttons.secondary-button class="block ml-auto mt-4"
            @click="$dispatch('open-modal', '{{ auth()->check() ? 'difficulty-subscription' : 'login' }}')">{{ __('Subscribe') }}</x-secondary-button>
    </div>

    <div
        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl mt-2 sm:mt-4 p-2 sm:p-4 lg:p-6">
        <h2 class="mb-2 lg:mb-4 text-lg sm:text-xl text-slate-800 dark:text-slate-200 font-extrabold">
            {{ __('Mining difficulty') }} {{ $coin->abbreviation }}
        </h2>

        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-2 sm:mb-4">
            {{ __('Find out how the profit of popular ASIC miners will change after recalculating the difficulty at a rate of 5 rubles/kW.') }}
        </p>

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b border-indigo-600">
                    <th class="py-1.5 md:py-4 text-left font-bold text-xs sm:text-sm text-slate-500">
                        {{ __('Model') }}
                    </th>
                    <th class="py-1.5 md:py-4 pl-2 sm:pl-4 text-right font-bold text-xs sm:text-sm text-slate-500">
                        {{ __('Current income') }}
                    </th>
                    <th class="py-1.5 md:py-4 pl-2 sm:pl-4 text-right font-bold text-xs sm:text-sm text-slate-500">
                        {{ __('Income after recalculation') }}
                    </th>
                    <th class="py-1.5 md:py-4 pl-2 sm:pl-4 text-right font-bold text-xs sm:text-sm text-slate-500 hidden xs:table-cell items-end">
                        {{ __('Percentage change') }}
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-300 dark:divide-slate-700">
                @foreach ($topModels as $model)
                    <tr>
                        <td class="py-1.5 lg:py-2 text-xxs sm:text-sm lg:text-base whitespace-nowrap">
                            <a href="{{ route('database.asic-miners.version', ['asicBrand' => $model['bs'], 'asicModel' => $model['s'], 'asicVersion' => $model['v']]) }}"
                                class="text-indigo-500 hover:text-indigo-600 underline">{{ $model['n'] }}</a>
                        </td>

                        <td
                            class="py-1.5 lg:py-2 pl-2 sm:pl-4 text-xxs xs:text-xs sm:text-sm lg:text-base text-right text-slate-800 dark:text-slate-200 whitespace-nowrap">
                            {{ $model['p'] }}
                        </td>

                        <td class="py-1.5 lg:py-2 pl-2 sm:pl-4 text-xxs xs:text-xs sm:text-sm lg:text-base text-right whitespace-nowrap"
                            :class="{
                                'text-green-500': {{ $prediction ?? 0 }} < 0,
                                'text-red-500': {{ $prediction ?? 0 }} > 0,
                                'text-slate-800 dark:text-slate-200': {{ $prediction ?? 0 }} == 0
                            }">
                            {{ $model['pp'] }}
                        </td>

                        <td class="py-1.5 lg:py-2 pl-2 sm:pl-4 text-xxs xs:text-xs sm:text-sm lg:text-base text-right whitespace-nowrap hidden xs:table-cell items-end"
                            :class="{
                                'text-green-500': {{ $prediction ?? 0 }} < 0,
                                'text-red-500': {{ $prediction ?? 0 }} > 0,
                                'text-slate-800 dark:text-slate-200': {{ $prediction ?? 0 }} == 0
                            }">
                            {{ $model['c'] }}
                        </td>

                        <td class="py-1.5 lg:py-2 pl-2 sm:pl-4 hidden lg:table-cell justify-items-end">
                            <a href="{{ route('calculator.modelver', ['asicModel' => $model['s'], 'asicVersion' => $model['v']]) }}">
                                <x-buttons.primary-button>{{ __('Calculator') }}</x-buttons.primary-button>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <section class="mt-4 sm:mt-6 lg:mt-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Miners for') }} {{ $coin->abbreviation }}
            </h2>
        </div>

        <div>
            <x-carousel.carousel :items="$ads" blade="ad.components.card" model="ad" :big="true" />
        </div>
    </section>

    @include('metrics.network.difficulty.components.faq')

    @include('metrics.network.difficulty.components.subscription')
</x-metrics-layout>
