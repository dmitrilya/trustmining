<div itemscope itemtype="https://schema.org/Product"
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14"
    x-data={} x-init="axios.post('/view/store', { viewable_type: 'asic-model', viewable_id: {{ $model->id }} })">
    {{-- <div class="mb-6 md:mb-12">
                @include('database.components.model-images')
            </div> --}}

    <div class="mx-auto md:grid md:grid-cols-3 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
        <div class="md:col-span-2 md:border-r border-slate-300 dark:border-slate-700 md:pr-8">
            <meta itemprop="brand" content="{{ $brand->name }}" />
            <div class="flex justify-between">
                <h1 itemprop="name"
                    class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl">
                    {{ $model->name }}</h1>

                <div
                    class="bg-slate-100 dark:bg-slate-950 rounded-full ml-3 p-1.5 sm:p-2 lg:p-2.5 tracking{{ auth()->user() && auth()->user()->trackedAsicModels->where('id', $model->id)->count() ? '' : ' hidden' }}">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-indigo-500" aria-hidden="true" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                    </svg>
                </div>
            </div>

            @include('database.asic-miners.versions')
        </div>

        <div class="mt-6 md:mt-0">
            <h2 class="sr-only">Информация</h2>

            <div class="w-full rounded-lg overflow-hidden mb-4 sm:mb-6">
                <img itemprop="image" class="w-full object-cover"
                    src="{{ Storage::url('asic-miners/' . $model->slug . '_380.webp') }}"
                    alt="{{ $brand->name }} {{ $model->name }}">
            </div>

            <x-characteristics.characteristics>
                <x-characteristics.characteristic name="Manufacturer" :value="$brand->name" itemprop="additionalProperty" />
                <x-characteristics.characteristic name="Algorithm" :value="$algorithms[$versions->first()['a']]['n']" itemprop="additionalProperty" />
                <x-characteristics.characteristic name="Cooling" :value="$model->characteristics['Cooling']" itemprop="additionalProperty" />
                <x-characteristics.characteristic name="Release date" :value="$model->release->locale(app()->getLocale())->translatedFormat('F Y')" />
                <meta itemprop="releaseDate" content="{{ $model->release->toIso8601String() }}">
            </x-characteristics.characteristics>

            @include('database.asic-miners.rating')

            <div class="flex flex-col gap-2 sm:gap-3 mt-4 sm:mt-6 lg:mt-8">
                @php
                    $trackClick = auth()->user()
                        ? 'axios.post("/track/handle", {trackable_type: "asic-model", trackable_id: ' .
                            $model->id .
                            '}).then(r => {
                                pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                                if (r.data.tracking) {
                                    document.getElementsByClassName("tracking")[0].classList.remove("hidden");
                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                            __('Untrack price') .
                            '";' .
                            (auth()->user()->tg_id === null
                                ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");'
                                : '') .
                            '} else {
                                document.getElementsByClassName("tracking")[0].classList.add("hidden");
                                $el.getElementsByTagName("span")[0].innerHTML = "' .
                            __('To track') .
                            '";
                            }
                        })'
                        : '$dispatch("open-modal", "login")';
                @endphp

                <x-buttons.secondary-button class="w-full justify-center" @click="{{ $trackClick }}">
                    <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                    </svg>
                    <span>{{ auth()->user() && auth()->user()->trackedAsicModels->where('id', $model->id)->count() ? __('Untrack price') : __('Track price') }}</span>
                </x-buttons.secondary-button>

                @if ($versions->min('p'))
                    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                        <meta itemprop="lowPrice" content="{{ $versions->min('p') }}" />
                        <meta itemprop="priceCurrency" content="USD" />
                        <link itemprop="url"
                            content="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />

                        <x-buttons.primary-button class="w-full h-full"
                            @click="document.querySelector('#infinite-loader').previousElementSibling.scrollIntoView({behavior: 'smooth'})">{{ __('Buy') }}</x-buttons.primary-button>
                    </div>
                @else
                    <div itemprop="offers" itemscope itemtype="https://schema.org/AggregateOffer">
                        <meta itemprop="lowPrice" content="0" />
                        <meta itemprop="priceCurrency" content="RUB" />
                        <link itemprop="url"
                            href="{{ route('ads', ['adCategory' => 'miners', 'model' => $model->slug]) }}" />
                    </div>

                    <x-buttons.primary-button
                        class="w-full h-full cursor-default opacity-50">{{ __('No ads') }}</x-buttons.primary-button>
                @endif

                <a href="{{ route('ads', ['adCategory' => 'miners']) }}">
                    <x-buttons.secondary-button class="w-full">{{ __('View all ads') }}</x-buttons.secondary-button>
                </a>
            </div>
        </div>
    </div>

    @include('database.asic-miners.tabs')
</div>
