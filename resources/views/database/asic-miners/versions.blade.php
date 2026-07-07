<div class="md:col-span-2 md:col-start-1 mt-4 md:mt-8" x-data="{ selectedTab: {{ array_search($selectedVersion['i'], $versions->pluck('i')->toArray()) }} }">
    <div
        class="text-xs font-semibold text-center text-slate-600 dark:text-slate-400 border-b-2 border-slate-300 dark:border-slate-700">
        <div
            class="flex -mb-px overflow-x-auto no-scrollbar whitespace-nowrap [mask-image:linear-gradient(to_right,black_80%,transparent_100%)]">
            @foreach ($versions as $i => $version)
                <button class="mr-1 sm:mr-2 -mb-[1px] inline-block p-1 xs:p-2 border-b-2 rounded-t-lg"
                    @click="selectedTab = {{ $i }}"
                    :class="{
                        'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': {{ $i }} !=
                            selectedTab,
                        'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-500': {{ $i }} ==
                            selectedTab
                    }">
                    {{ $version['h'] }}{{ $version['m'] }}
                </button>

                <a href="{{ route('database.asic-miners.version', [
                    'asicBrand' => $brand->slug,
                    'asicModel' => $model->slug,
                    'asicVersion' => $version['h'] . $version['m'],
                ]) }}"
                    aria-label="{{ $model->name . ' ' . $version['h'] . $version['m'] }}"></a>
            @endforeach
        </div>
    </div>

    @foreach ($versions as $i => $version)
        <div x-show="selectedTab == {{ $i }}" itemprop="model" itemscope
            itemtype="http://schema.org/ProductModel"
            style="display: {{ $version['i'] == $selectedVersion['i'] ? 'block' : 'none' }}">
            <meta itemprop="name" content="{{ $model->name . ' ' . $version['h'] . $version['m'] }}" />

            <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-4 md:my-6">
                <x-characteristic name="Hashrate" :value="$version['h']" itemprop="hasMeasurement" :unit="[
                    'prop' => 'unitText',
                    'content' => $version['m'] . '/s',
                ]" />
                <x-characteristic name="Efficiency" :value="$version['e']" itemprop="hasMeasurement" :unit="[
                    'prop' => 'unitText',
                    'content' => 'j/' . $version['m'],
                ]" />
                <x-characteristic name="Power" :value="$version['e'] * $version['h']" itemprop="hasMeasurement" :unit="['prop' => 'unitCode', 'content' => 'W']" />
                @if ($version['p'])
                    <x-characteristic name="The best price" :value="$version['p'] . ' USDT'" />
                @endif
            </x-characteristics>

            @if ($version['p'])
                @if (count($algorithms[$version['a']]['p']))
                    @include('ad.components.payback_info', [
                        'profit' => $algorithms[$version['a']]['p'][0]['p'] * $version['h'] * $version['c'],
                        'expense' => (($version['h'] * $version['e'] * 24) / 1000) * $rub,
                        'tariff' => 5,
                        'price' => $version['p'],
                    ])
                @endif

                <div class="xs:flex mt-6 md:mt-8 ">
                    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                        <meta itemprop="lowPrice" content="{{ $version['p'] }}" />
                        <meta itemprop="offerCount" content="{{ $version['ac'] }}" />
                        <meta itemprop="priceCurrency" content="USD" />
                        <link itemprop="url"
                            href="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug, 'asic_version_id' => $version['i']]) }}" />
                    </div>

                    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/ViewAction"
                        class="mt-2 xs:mt-0">
                        <meta itemprop="name"
                            content="{{ __('Income calculator') }} {{ $brand->name }} {{ $model->name }} {{ $version['h'] }}{{ $version['m'] }}" />

                        <div itemprop="target" itemscope itemtype="https://schema.org/EntryPoint">
                            <a itemprop="urlTemplate" class="block w-full xs:w-fit"
                                href="{{ route('calculator.modelver', ['asicModel' => $model->slug, 'asicVersion' => $version['h']]) }}">
                                <x-secondary-button
                                    class="bg-secondary-gradient dark:text-slate-800 w-full justify-center">{{ __('Income calculator') }}</x-secondary-button>
                            </a>
                        </div>
                    </div>
                </div>
            @else
                @if (count($algorithms[$version['a']]['p']))
                    @include('ad.components.payback_info', [
                        'profit' => $algorithms[$version['a']]['p'][0]['p'] * $version['h'] * $version['c'],
                        'expense' => (($version['h'] * $version['e'] * 24) / 1000) * $rub,
                        'tariff' => 5,
                        'price' => 0,
                    ])
                @endif

                <div class="flex mt-6 md:mt-8">
                    <div itemprop="potentialAction" itemscope itemtype="https://schema.org/ViewAction">
                        <meta itemprop="name"
                            content="{{ __('Income calculator') }} {{ $brand->name }} {{ $model->name }} {{ $version['h'] }}{{ $version['m'] }}" />

                        <div itemprop="target" itemscope itemtype="https://schema.org/EntryPoint">
                            <a itemprop="urlTemplate" class="block w-fit"
                                href="{{ route('calculator.modelver', ['asicModel' => $model->slug, 'asicVersion' => $version['h']]) }}">
                                <x-secondary-button
                                    class="bg-secondary-gradient dark:text-slate-800">{{ __('Income calculator') }}</x-secondary-button>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <h2 class="text-sm text-slate-800 dark:text-slate-200 mt-8 mb-3">
                {{ __('How many coins does it mine per day') }}
            </h2>

            <div class="grid gap-2 grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
                @foreach (collect($algorithms[$version['a']]['p'])->pluck('c')->flatten(1)->where('p', '>', 0) as $coin)
                    <div>
                        <div class="flex items-center">
                            <img alt="{{ $coin['n'] }}" class="w-5 xs:w-6 mr-1 xs:mr-2"
                                src="{{ Storage::url('public/coins/' . $coin['a'] . '.webp') }}" />
                            <div>
                                <div class="text-xs xs:text-sm text-slate-600 dark:text-slate-400">
                                    {{ $coin['a'] }}
                                </div>
                                <div class="text-xxs xs:text-xs text-slate-500">
                                    {{ $coin['n'] }}
                                </div>
                            </div>
                        </div>
                        <div class="text-xxs xxs:text-xs text-slate-800 dark:text-slate-200 font-bold mt-0.5 xs:mt-1">
                            {{ number_format($version['h'] * $coin['p'], 8) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
