<div itemscope itemtype="https://schema.org/Product"
    class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14">
    <meta itemprop="sku" content="{{ $ad->id }}">
    <link itemprop="url" href="{{ url()->current() }}">
    <meta itemprop="description" content="{{ $description }}">
    @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpu')
        <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
            @php
                $reviewsCount = $ad->asicVersion->asicModel->moderatedReviews->count();
            @endphp

            <meta itemprop="ratingValue" content="{{ $reviewsCount ? $ad->asicVersion->asicModel->moderatedReviews->avg('rating') : '4.8' }}" />
            <meta itemprop="reviewCount" content="{{ $reviewsCount ? $reviewsCount : '15' }}" />
            <meta itemprop="worstRating" content="1" />
            <meta itemprop="bestRating" content="5" />
        </div>
    @endif
    <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 offer-card">
        <div class="md:col-span-5">
            <div class="h-full flex flex-col justify-between">
                <div class="{{ $preview['changed'] || $images['changed'] ? 'border border-indigo-500' : '' }}">
                    <x-images :images="[$preview['data'], ...$images['data']]" :alt="$alt" />
                </div>

                <div class="hidden md:block">
                    @include('ad.components.characteristics')
                </div>
            </div>
        </div>

        <div class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l border-slate-300 dark:border-slate-700 md:pl-8">
            <div class="flex items-start justify-between">
                @if ($ad->adCategory->name == 'miners')
                    <meta itemprop="brand" content="{{ $ad->asicVersion->asicModel->asicBrand->name }}" />
                @elseif ($ad->adCategory->name == 'gpus')
                    <meta itemprop="brand" content="{{ $ad->gpuModel->gpuBrand->name }}" />
                    <meta itemprop="name" content="{{ $ad->gpuModel->name }}" />
                @endif

                <h1 itemprop="name" class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl">
                    {{ $name }}
                </h1>

                <div
                    class="bg-slate-100 dark:bg-slate-950 rounded-full ml-3 p-1.5 sm:p-2 lg:p-2.5 tracking{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? '' : ' hidden' }}">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-indigo-500" aria-hidden="true" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                    </svg>
                </div>
            </div>

            <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpu')
                    <link itemprop="availability" href="https://schema.org/{{ $props['data']['Availability'] == 'In stock' ? 'InStock' : 'PreOrder' }}" />
                    <link itemprop="itemCondition" href="https://schema.org/{{ $props['data']['Condition'] == 'New' ? 'NewCondition' : 'UsedCondition' }}" />
                    <div itemprop="shippingDetails" itemscope itemtype="https://schema.org/OfferShippingDetails">
                        <div itemprop="shippingRate" itemscope itemtype="https://schema.org/MonetaryAmount">
                            <meta itemprop="value" content="0" />
                            <meta itemprop="currency" content="RUB" />
                        </div>
                        <div itemprop="deliveryTime" itemscope itemtype="https://schema.org/ShippingDeliveryTime">
                            <div itemprop="handlingTime" itemscope itemtype="https://schema.org/QuantitativeValue">
                                <meta itemprop="minValue" content="0" />
                                <meta itemprop="maxValue" content="1" />
                                <meta itemprop="unitCode" content="d" />
                            </div>
                            <div itemprop="transitTime" itemscope itemtype="https://schema.org/QuantitativeValue">
                                @if ($props['data']['Availability'] == 'In stock')
                                    <meta itemprop="minValue" content="0" />
                                    <meta itemprop="maxValue" content="3" />
                                    <meta itemprop="unitCode" content="d" />
                                @else
                                    <meta itemprop="minValue" content="{{ $props['data']['Waiting (days)'] - round($props['data']['Waiting (days)'] / 5) }}" />
                                    <meta itemprop="maxValue" content="{{ $props['data']['Waiting (days)'] }}" />
                                    <meta itemprop="unitCode" content="d" />
                                @endif
                            </div>
                        </div>
                        <div itemprop="shippingDestination" itemscope itemtype="https://schema.org/DefinedRegion">
                            <meta itemprop="addressCountry" content="RU" />
                        </div>
                    </div>

                    @if ($props['data']['Condition'] == 'New')
                        <div itemprop="hasMerchantReturnPolicy" itemscope itemtype="https://schema.org/MerchantReturnPolicy">
                            <link itemprop="returnPolicyCategory" href="https://schema.org/MerchantReturnFiniteReturnWindow" />
                            <link itemprop="returnMethod" href="https://schema.org/ReturnInStore" />
                            <link itemprop="returnFees" href="https://schema.org/ReturnFeesCustomerResponsibility" />
                            <link itemprop="refundType" href="https://schema.org/FullRefund" />
                            <meta itemprop="applicableCountry" content="RU" />
                            <meta itemprop="merchantReturnDays" content="14" />
                        </div>
                    @else
                        <div itemprop="hasMerchantReturnPolicy" itemscope itemtype="https://schema.org/MerchantReturnPolicy">
                            <link itemprop="returnPolicyCategory" href="https://schema.org/MerchantReturnNotPermitted" />
                            <meta itemprop="applicableCountry" content="RU" />
                        </div>
                    @endif
                @endif

                @if ($price['data'] != 0)
                    <div class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200{{ $price['changed'] ? ' border border-indigo-500' : '' }}">
                        <meta itemprop="priceCurrency" content="{{ $coin['data'] != 'USDT' ? $coin['data'] : 'USD' }}" />
                        <meta itemprop="valueAddedTaxIncluded" content="{{ $with_vat['data'] ? 'true' : 'false' }}" />

                        @if (
                            $ad->adCategory->name == 'miners' &&
                                data_get($ad, 'version_data.price_data.' . $props['data']['Condition'] . '.' . $props['data']['Availability'], null) !== null)
                            @include('ad.components.price-graduation', [
                                'price' => $price['data'] . ' ' . $coin['data'],
                                'withVat' => $with_vat['data'],
                                'priceData' => $ad->version_data->price_data[$props['data']['Condition']][$props['data']['Availability']],
                            ])
                        @else
                            <div><span itemprop="price">{{ $price['data'] }}</span> {{ $coin['data'] }}</div>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-1 xs:gap-2 mt-4">
                        @if ($latestModerationDate = $ad->acceptedModerations()->whereNotNull('data->price')->latest()->value('created_at'))
                            <div class="bg-indigo-500/10 border border-indigo-500/30 text-indigo-500 text-xxs xs:text-xs w-fit rounded-md px-1.5 py-0.5">
                                {{ __('Price updated') }}
                                {{ $latestModerationDate->diffForHumans() }}
                            </div>
                        @endif

                        @if ($with_vat['data'])
                            <div
                                class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-xxs xs:text-xs w-fit rounded-md px-1.5 py-0.5">
                                {{ __('The price includes VAT') }}
                            </div>
                        @endif
                    </div>
                @else
                    <div itemprop="priceSpecification" itemscope itemtype="https://schema.org/PriceSpecification">
                        <meta itemprop="price" content="0" />
                        <meta itemprop="priceCurrency" content="{{ $coin['data'] != 'USDT' ? $coin['data'] : 'USD' }}" />
                        <meta itemprop="valueAddedTaxIncluded" content="{{ $with_vat['data'] ? 'true' : 'false' }}" />
                        <p itemprop="description"
                            class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200 flex items-center{{ $price['changed'] ? ' border border-indigo-500' : '' }}">
                            {{ __('Price on request') }}
                        </p>
                    </div>
                @endif

                <a href="{{ route('company.office', ['user' => $ad->user->slug, 'office' => $ad->office->id]) }}" target="_blank"
                    class="flex items-center hover:underline text-xxs xxs:text-xs sm:text-sm text-indigo-500 hover:text-indigo-600 mt-4 lg:mt-6">
                    <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $ad->office->address }}
                </a>

                <x-characteristics.characteristics class="my-5 sm:my-6 lg:my-7">
                    @if ($ad->adCategory->name == 'firmwares')
                        <x-characteristics.characteristic name="Model" :value="$ad->asicVersion->asicModel->name . ' ' . (float) $ad->asicVersion->hashrate . ' ' . $ad->asicVersion->measurement . '/s'" />
                    @endif

                    @foreach ($props['data'] as $prop => $value)
                        @if ($prop != 'Service')
                            @php
                                if ($prop == 'Modes') {
                                    $modes = collect($value)->sortBy('h');
                                    $value = $modes->first()['h'] . $ad->asicVersion->measurement;
                                    if ($modes->count() > 1) {
                                        $value .= '-' . $modes->last()['h'] . $ad->asicVersion->measurement;
                                    }
                                }
                            @endphp

                            <x-characteristics.characteristic :name="$prop" :value="$value" />
                        @else
                            <div class="text-xxs sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                                <span>{{ __($prop) . ': ' }}</span><span class="text-slate-800 dark:text-slate-200">{{ __($value) }}</span>
                            </div>
                        @endif
                    @endforeach
                </x-characteristics.characteristics>

                <div>
                    @include('ad.components.about-seller', [
                        'user' => $ad->user,
                        'address' => [
                            'city' => $ad->office->city,
                            'street' => trim(implode(',', array_slice(explode(',', $ad->office->address), 2))),
                            'postal' => $ad->office->postal_code,
                        ],
                        'phone' => $ad->user->phones->first(),
                    ])

                    @include('ad.components.action-buttons')
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8" x-data="{ selectedTab: 'description' }">
        <div class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 dark:text-slate-400 border-b border-slate-300 dark:border-slate-700">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-0.5 sm:mr-2">
                    <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'description'"
                        :class="{
                            'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'description' !=
                                selectedTab,
                            'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'description' ==
                                selectedTab
                        }">
                        {{ __('Description') }}
                    </button>
                </li>
                <li class="mr-0.5 sm:mr-2 md:hidden">
                    <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'characteristics'"
                        :class="{
                            'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'characteristics' !=
                                selectedTab,
                            'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'characteristics' ==
                                selectedTab
                        }">
                        {{ __('Characteristics') }}
                    </button>
                </li>
                <li class="mr-0.5 sm:mr-2">
                    <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'reviews'"
                        :class="{
                            'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'reviews' !=
                                selectedTab,
                            'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'reviews' ==
                                selectedTab
                        }">
                        {{ __('Reviews') }}
                    </button>
                </li>
                <li>
                    <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg" @click="selectedTab = 'location'"
                        :class="{
                            'border-transparent hover:text-slate-800 dark:hover:text-slate-200 hover:border-slate-400 dark:hover:border-slate-600': 'location' !=
                                selectedTab,
                            'text-indigo-500 border-indigo-600 active dark:text-indigo-500 dark:border-indigo-600': 'location' ==
                                selectedTab
                        }">
                        {{ __('Location') }}
                    </button>
                </li>
            </ul>
        </div>

        <div x-show="selectedTab == 'description'">
            <x-can-trust :user="$ad->user" :id="$ad->id" />

            <div class="{{ $adDescription['changed'] ? 'border border-indigo-500' : '' }}">
                @include('ad.components.description', ['description' => $adDescription['data']])
            </div>
        </div>

        <div x-show="selectedTab == 'characteristics'" style="display: none">
            @include('ad.components.characteristics')
        </div>

        <div class="space-y-6" x-show="selectedTab == 'reviews'" style="display: none">
            @include('review.reviews', ['auth' => $user, 'reviews' => $ad->user->reviews])
            @include('review.send', [
                'auth' => $user,
                'reviews' => $ad->user->reviews,
                'type' => 'user',
                'id' => $ad->user->id,
            ])
        </div>

        <div x-show="selectedTab == 'location'" style="display: none">
            @include('ad.components.location', ['location' => $ad->user->name . ', ' . $ad->office->address])
        </div>
    </div>
</div>
