<x-app-layout
    title="{{ $brand->name }} {{ $model->name }} {{ $selectedVersion['h'] }}{{ $selectedVersion['m'] }}/s - доходность и объявления"
    description="{{ $brand->name }} {{ $model->name }} {{ $selectedVersion['h'] }}{{ $selectedVersion['m'] }}/s. Характеристики, потребление, доходность и окупаемость. Актуальные предложения и цены. Купить {{ $model->name }} с доставкой по РФ на TRUSTMINING"
    canonical="{{ route('database.asic-miners.version', [
        'asicBrand' => $brand->slug,
        'asicModel' => $model->slug,
        'asicVersion' => $selectedVersion['h'] . $selectedVersion['m'],
    ]) }}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" :href="route('database.asic-miners')" :name="__('ASIC-miners')" />
            <x-breadcrumb position="2" :href="route('database.asic-miners.brand', ['asicBrand' => $brand->slug])" :name="$brand->name" />
            @if (request()->routeIs('database.asic-miners.model'))
                <x-breadcrumb position="3" :name="$model->name" />
            @else
                <x-breadcrumb position="3" :href="route('database.asic-miners.model', [
                    'asicBrand' => $brand->slug,
                    'asicModel' => $model->slug,
                ])" :name="$model->name" />
                <x-breadcrumb position="4" :name="$selectedVersion['h'] . $selectedVersion['m']" />
            @endif
        </x-breadcrumbs>

        <div itemscope itemtype="https://schema.org/Product"
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14"
            x-data={} x-init="axios.post('/view/store', { viewable_type: 'asic-model', viewable_id: {{ $model->id }} })">
            {{-- <div class="mb-6 md:mb-12">
                @include('database.components.model-images')
            </div> --}}

            <div class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
                <div class="md:col-span-2 md:border-r border-slate-300 dark:border-slate-700 md:pr-8">
                    <meta itemprop="brand" content="{{ $brand->name }}" />
                    <h1 itemprop="name"
                        class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                        {{ $model->name }}</h1>

                    <div class="md:col-span-2 md:col-start-1 mt-4 md:mt-8" x-data="{ selectedTab: {{ array_search($selectedVersion['i'], $versions->pluck('i')->toArray()) }} }">
                        <div
                            class="text-xs font-semibold text-center text-slate-600 dark:text-slate-300 border-b-2 border-slate-300 dark:border-slate-700">
                            <div
                                class="flex -mb-px overflow-x-auto no-scrollbar whitespace-nowrap [mask-image:linear-gradient(to_right,black_80%,transparent_100%)]">
                                @foreach ($versions as $i => $version)
                                    <button
                                        class="mr-1 sm:mr-2 -mb-[1px] inline-block p-1 xs:p-2 border-b-2 rounded-t-lg"
                                        @click="selectedTab = {{ $i }}"
                                        :class="{
                                            'border-transparent hover:text-slate-600 dark:hover:text-slate-300 hover:border-slate-400 dark:hover:border-slate-600': {{ $i }} !=
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
                                <meta itemprop="name"
                                    content="{{ $model->name . ' ' . $version['h'] . $version['m'] }}" />

                                <x-characteristics class="lg:grid grid-cols-2 gap-x-4 my-4 md:my-6">
                                    <x-characteristic name="Hashrate" :value="$version['h']" itemprop="hasMeasurement"
                                        :unit="[
                                            'prop' => 'unitText',
                                            'content' => $version['m'] . '/s',
                                        ]" />
                                    <x-characteristic name="Efficiency" :value="$version['e']" itemprop="hasMeasurement"
                                        :unit="[
                                            'prop' => 'unitText',
                                            'content' => 'j/' . $version['m'],
                                        ]" />
                                    <x-characteristic name="Power" :value="$version['e'] * $version['h']" itemprop="hasMeasurement"
                                        :unit="['prop' => 'unitCode', 'content' => 'W']" />
                                    @if ($version['p'])
                                        <x-characteristic name="The best price" :value="$version['p'] . ' USDT'" />
                                    @endif
                                </x-characteristics>

                                @if ($version['p'])
                                    @if (count($algorithms[$version['a']]['p']))
                                        @include('ad.components.payback_info', [
                                            'profit' =>
                                                $algorithms[$version['a']]['p'][0]['p'] *
                                                $version['h'] *
                                                $version['c'],
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

                                        <div itemprop="potentialAction" itemscope
                                            itemtype="https://schema.org/ViewAction" class="mt-2 xs:mt-0">
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
                                            'profit' =>
                                                $algorithms[$version['a']]['p'][0]['p'] *
                                                $version['h'] *
                                                $version['c'],
                                            'expense' => (($version['h'] * $version['e'] * 24) / 1000) * $rub,
                                            'tariff' => 5,
                                            'price' => 0,
                                        ])
                                    @endif

                                    <div class="flex mt-6 md:mt-8">
                                        <div itemprop="potentialAction" itemscope
                                            itemtype="https://schema.org/ViewAction">
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

                                <h2 class="text-sm text-slate-950 dark:text-slate-100 mt-8 mb-3">
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
                                            <div
                                                class="text-xxs xxs:text-xs text-slate-800 dark:text-slate-200 font-bold mt-0.5 xs:mt-1">
                                                {{ number_format($version['h'] * $coin['p'], 8) }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 md:mt-0">
                    <h2 class="sr-only">Информация</h2>

                    <div class="w-full mb-4 sm:mb-6">
                        @php
                            $previewxs = 'asic-miners/' . $model->slug . '_224' . '.webp';
                            $previewsm = 'asic-miners/' . $model->slug . '_320' . '.webp';
                        @endphp

                        <picture class="w-full">
                            <source media="(max-width: 430px)" srcset="{{ Storage::url($previewxs) }}">

                            <img itemprop="image" class="w-full object-cover" src="{{ Storage::url($previewsm) }}"
                                alt="{{ $brand->name }} {{ $model->name }}">
                        </picture>
                    </div>

                    <x-characteristics>
                        <x-characteristic name="Manufacturer" :value="$brand->name" itemprop="additionalProperty" />
                        <x-characteristic name="Algorithm" :value="$algorithms[$version['a']]['n']" itemprop="additionalProperty" />
                        <x-characteristic name="Cooling" :value="$model->characteristics['Cooling']" itemprop="additionalProperty" />
                        <x-characteristic name="Release date" :value="$model->release->locale(app()->getLocale())->translatedFormat('F Y')" />
                        <meta itemprop="releaseDate" content="{{ $model->release->toIso8601String() }}">
                    </x-characteristics>

                    <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating"
                        class="mt-4 sm:mt-6">
                        <h3 class="sr-only">{{ __('Reviews') }}</h3>
                        <div class="flex items-center" x-data="{ momentRating: {{ $model->reviews_avg ?? 0 }} }">
                            <x-rating></x-rating>
                            @if ($model->reviews_count)
                                <meta itemprop="ratingValue" content="{{ $model->reviews_avg }}" />
                                <meta itemprop="reviewCount" content="{{ $model->reviews_count }}" />
                            @else
                                <meta itemprop="ratingValue" content="4.8" />
                                <meta itemprop="reviewCount" content="15" />
                            @endif
                            <meta itemprop="worstRating" content="1" />
                            <meta itemprop="bestRating" content="5" />

                            <a itemprop="url"
                                href="{{ route('database.asic-miners.reviews', [
                                    'asicBrand' => $brand->slug,
                                    'asicModel' => $model->slug,
                                ]) }}"
                                class="ml-3 text-sm text-indigo-500 hover:text-indigo-600">
                                <span>{{ $model->reviews_count }}</span>
                                {{ trans_choice('navigation.reviews', $model->reviews_count) }}
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:gap-3 mt-4 sm:mt-6 lg:mt-8">
                        @if ($versions->min('p'))
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <meta itemprop="lowPrice" content="{{ $versions->min('p') }}" />
                                <meta itemprop="priceCurrency" content="USD" />
                                <link itemprop="url"
                                    content="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />

                                <x-primary-button class="w-full h-full"
                                    @click="document.querySelector('#infinite-loader').previousElementSibling.scrollIntoView({behavior: 'smooth'})">{{ __('Buy') }}</x-primary-button>
                            </div>
                        @else
                            <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                                <meta itemprop="lowPrice" content="0" />
                                <meta itemprop="priceCurrency" content="RUB" />
                                <link itemprop="url"
                                    href="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />
                            </div>

                            <x-primary-button
                                class="w-full h-full cursor-default opacity-60">{{ __('No ads') }}</x-primary-button>
                        @endif

                        <a href="{{ route('ads', ['adCategory' => 'miners']) }}">
                            <x-secondary-button class="w-full">{{ __('View all ads') }}</x-secondary-button>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-8" x-data="{ selectedTab: 'description' }">
                <div
                    class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 border-b border-slate-300 dark:text-slate-300 dark:border-slate-800">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'description'"
                                :class="{
                                    'border-transparent hover:text-slate-600 hover:border-slate-300 dark:hover:text-slate-300': 'description' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'description' ==
                                        selectedTab
                                }">
                                {{ __('Description') }}
                            </button>
                        </li>
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'reviews'"
                                :class="{
                                    'border-transparent hover:text-slate-600 hover:border-slate-300 dark:hover:text-slate-300': 'reviews' !=
                                        selectedTab,
                                    'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'reviews' ==
                                        selectedTab
                                }">
                                {{ __('Reviews') }}
                            </button>
                        </li>
                    </ul>
                </div>

                <div x-show="selectedTab == 'description'">
                    @include('database.asic-miners.description')
                </div>

                <div class="space-y-6" x-show="selectedTab == 'reviews'" style="display: none">
                    @include('review.reviews', ['auth' => auth()->user(), 'reviews' => $model->reviews])
                    @include('review.send', [
                        'auth' => auth()->user(),
                        'reviews' => $model->reviews,
                        'type' => 'asic-model',
                        'id' => $model->id,
                    ])
                </div>
            </div>
        </div>

        <section class="mt-4 sm:mt-6 lg:mt-8" x-data="{ tab: 'simmilar' }">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Compare with') }}
                </h2>

                <div class="flex text-xs s m:text-sm">
                    <button @click="tab = 'simmilar'"
                        :class="tab === 'simmilar' ?
                            'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Similar') }}
                    </button>
                    <button @click="tab = 'popular'"
                        :class="tab === 'popular' ?
                            'bg-slate-100 dark:bg-slate-800 shadow-sm text-slate-700 dark:text-slate-300' :
                            'text-slate-500'"
                        class="px-3 py-1 rounded-full transition-all">
                        {{ __('Popular') }}
                    </button>
                </div>
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'simmilar'"
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Comparing with') . ' ' . __('Similar') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('database.asic-miners.compare-carousel', [
                    'asicModels' => $comparing['same_algo'],
                    'characteristics' => [
                        [
                            'name' => __('Speed'),
                            'value' => fn($model) => $model->maxRate . ' ' . $model->algorithm->measurement . '/s',
                        ],
                    ],
                ])
            </div>

            <div itemscope itemtype="https://schema.org/ItemList" x-show="tab === 'popular'" x-cloak
                x-transition:enter.duration.400ms>
                <meta itemprop="name" content="{{ __('Comparing with') . ' ' . __('Popular') }}" />
                <meta itemprop="itemListOrder" content="https://schema.org/ItemListOrderDescending" />

                @include('database.asic-miners.compare-carousel', [
                    'asicModels' => $comparing['diff_algo'],
                    'characteristics' => [
                        [
                            'name' => __('Release'),
                            'value' => fn($model) => $model->release->locale(app()->getLocale())->translatedFormat('F Y'),
                        ],
                    ],
                ])
            </div>
        </section>

        <section class="mt-4 sm:mt-6 lg:mt-8">
            <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                    {{ __('Offers') }} {{ $brand->name }} {{ $model->name }}
                </h2>
            </div>

            {{-- request()->routeIs('database.asic-miners.model')
                    ? route('database.asic-miners.model.get-ads', ['asicBrand' => $brand->slug, 'asicModel' => $model->slug])
                    : route('database.asic-miners.version.get-ads', [
                        'asicBrand' => $brand->slug,
                        'asicModel' => $model->slug,
                        'asicVersion' => $selectedVersion['h'] . $selectedVersion['m'],
                    ]) --}}

            <div class="grid gap-2 grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5" id="infinite-loader"
                x-data="{}" x-init="new InfiniteLoader({ endpoint: '{{ route('database.asic-miners.model.get-ads', ['asicBrand' => $brand->slug, 'asicModel' => $model->slug]) }}', page: {{ $ads->currentPage() }}, lastPage: {{ $ads->lastPage() }} });">
                @include('ad.components.list', ['owner' => false])
            </div>
        </section>
    </div>
</x-app-layout>
