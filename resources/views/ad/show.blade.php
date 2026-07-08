@php
    $user = Auth::user();
    [$title, $description, $alt, $canonicalHref, $name] = (new App\Services\AdService())->getMetaData($ad);
@endphp

<x-app-layout :description="$description" :title="$title" :noindex="isset($moderation) ? 'true' : null" :canonical="$canonicalHref">
    <x-slot name="og">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ Storage::disk('public')->url($ad->preview) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="product">
    </x-slot>

    <script src="https://api-maps.yandex.ru/v3/?apikey=edbdf37c-6677-43bf-8434-455e393b7362&lang=ru_RU"></script>

    @if ($ad->description || isset($moderation->data['description']))
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    @endif

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 md:p-8">
        @include('ad.components.breadcrumbs')

        @if (isset($moderation))
            @include('moderation.components.buttons', ['withUniqueCheck' => true])

            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 mb-6 lg:p-14">
                <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8">
                    <div
                        class="md:col-span-5{{ isset($moderation->data['preview']) || isset($moderation->data['images']) ? ' border border-indigo-500' : '' }}">
                        @php
                            $i = isset($moderation->data['images']) ? $moderation->data['images'] : $ad->images;
                            $p = isset($moderation->data['preview']) ? $moderation->data['preview'] : $ad->preview;
                        @endphp

                        @if (!count($i))
                            <div class="w-full overflow-hidden rounded-lg col-start-2">
                                <img src="{{ Storage::url($p) }}" class="w-full object-cover object-center">
                            </div>
                        @else
                            <x-carousel :images="array_merge([$p], $i)"></x-carousel>
                        @endif
                    </div>

                    <div
                        class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l border-slate-300 dark:border-slate-700 md:pl-8">
                        <h1
                            class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl">
                            {{ $name }}
                        </h1>

                        <p
                            class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200{{ isset($moderation->data['price']) ? ' border border-indigo-500' : '' }}">
                            @if (isset($moderation->data['price']))
                                @if ($moderation->data['price'] != 0)
                                    {{ $moderation->data['price'] }} {{ $ad->coin->abbreviation }}
                                    @if ($moderation->data['with_vat'])
                                        <span
                                            class="text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                                    @endif
                                @else
                                    {{ __('Price on request') }}
                                @endif
                            @else
                                @if ($ad->price != 0)
                                    {{ $ad->price }} {{ $ad->coin->abbreviation }}
                                    @if ($ad->with_vat)
                                        <span
                                            class="text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                                    @endif
                                @else
                                    {{ __('Price on request') }}
                                @endif
                            @endif
                        </p>

                        <a href="{{ route('company.office', ['user' => $ad->user->slug, 'office' => isset($moderation->data['office_id']) ? $moderation->data['office_id'] : $ad->office->id]) }}"
                            target="_blank"
                            class="flex items-center hover:underline text-xxs xs:text-xs sm:text-sm sm:text-base text-indigo-500 hover:text-indigo-600 mt-2 sm:mt-3 md:mt-4{{ isset($moderation->data['office_id']) ? ' border border-indigo-500' : '' }}">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ isset($moderation->data['office_id']) ? App\Models\User\Office::find($moderation->data['office_id'])->address : $ad->office->address }}
                        </a>

                        @php
                            $props = isset($moderation->data['props']) ? $moderation->data['props'] : $ad->props;
                        @endphp

                        <div class="md:col-span-2 md:col-start-1">
                            <x-characteristics.characteristics class="my-5 sm:my-6 lg:my-7">
                                @foreach ($ad->props as $prop => $value)
                                    <x-characteristics.characteristic :name="$prop" :value="$value" />
                                @endforeach
                            </x-characteristics.characteristics>

                            <div>
                                @include('ad.components.about-seller', [
                                    'user' => $ad->user,
                                    'address' => [
                                        'city' => $ad->office->city,
                                        'street' => trim(
                                            implode(',', array_slice(explode(',', $ad->office->address), 2))),
                                        'postal' => $ad->office->postal_code,
                                    ],
                                    'phone' => $ad->user->phones->first(),
                                    'auth' => $user,
                                ])
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($moderation->data['description']))
                    <div class="mt-8">
                        @include('ad.components.description', [
                            'description' => $moderation->data['description'],
                        ])
                    </div>
                @endif
            </div>
        @endif

        <div itemscope itemtype="https://schema.org/Product"
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14">
            <meta itemprop="sku" content="{{ $ad->id }}">
            <link itemprop="url" href="{{ url()->current() }}">
            <meta itemprop="description" content="{{ $description }}">
            @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpu')
                <div itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                    @php
                        $reviewsCount = $ad->asicVersion->asicModel->moderatedReviews->count();
                    @endphp

                    <meta itemprop="ratingValue"
                        content="{{ $reviewsCount ? $ad->asicVersion->asicModel->moderatedReviews->avg('rating') : '4.8' }}" />
                    <meta itemprop="reviewCount" content="{{ $reviewsCount ? $reviewsCount : '15' }}" />
                    <meta itemprop="worstRating" content="1" />
                    <meta itemprop="bestRating" content="5" />
                </div>
            @endif
            <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 offer-card">
                <div class="md:col-span-5">
                    <div class="h-full flex flex-col justify-between">
                        <div class="flex gap-2" x-data="{ active: 0 }">
                            <div class="min-w-16 w-16 flex flex-col gap-2">
                                <div @click="active = 0"
                                    class="w-full aspect-[4/3] rounded-lg cursor-pointer transition"
                                    :class="active === 0 ? 'ring-2 ring-indigo-500' : 'opacity-70 hover:opacity-100'">
                                    <img src="{{ Storage::url($ad->preview) }}"
                                        alt="{{ $alt }} {{ __('Preview') }}"
                                        class="w-full h-full rounded-lg object-cover">
                                </div>

                                @foreach ($ad->images as $index => $image)
                                    <div @click="active = {{ $index + 1 }}"
                                        class="w-full aspect-[4/3] rounded-lg cursor-pointer transition"
                                        :class="active === {{ $index + 1 }} ? 'ring-2 ring-indigo-500' :
                                            'opacity-70 hover:opacity-100'">
                                        <img src="{{ Storage::url($image) }}"
                                            alt="{{ $alt }} {{ __('Preview') }} {{ $index + 2 }}"
                                            class="w-full h-full rounded-lg object-cover">
                                    </div>
                                @endforeach
                            </div>

                            <div class="relative w-full aspect-[4/3] rounded-lg overflow-hidden bg-slate-100">
                                <div x-show="active === 0" x-transition.opacity.duration.300ms class="absolute inset-0">
                                    <img itemprop="image" src="{{ Storage::url($ad->preview) }}"
                                        alt="{{ $alt }}" class="w-full h-full object-cover">
                                </div>

                                @foreach ($ad->images as $index => $image)
                                    <div x-show="active === {{ $index + 1 }}" x-transition.opacity.duration.300ms
                                        class="absolute inset-0">
                                        <img src="{{ Storage::url($image) }}"
                                            alt="{{ $alt }} {{ $index + 2 }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="hidden md:block">
                            @include('ad.components.characteristics')
                        </div>
                    </div>
                </div>

                <div
                    class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l border-slate-300 dark:border-slate-700 md:pl-8">
                    <div class="flex items-start justify-between">
                        @if ($ad->adCategory->name == 'miners')
                            <meta itemprop="brand" content="{{ $ad->asicVersion->asicModel->asicBrand->name }}" />
                        @elseif ($ad->adCategory->name == 'gpus')
                            <meta itemprop="brand" content="{{ $ad->gpuModel->gpuBrand->name }}" />
                            <meta itemprop="name" content="{{ $ad->gpuModel->name }}" />
                        @endif

                        <h1 itemprop="name"
                            class="text-xl font-bold tracking-tight text-slate-800 dark:text-slate-200 sm:text-2xl md:text-3xl">
                            {{ $name }}
                        </h1>

                        <div
                            class="bg-slate-100 dark:bg-slate-950 rounded-full ml-3 p-1.5 sm:p-2 lg:p-2.5 tracking{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? '' : ' hidden' }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-indigo-500" aria-hidden="true"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                            </svg>
                        </div>
                    </div>

                    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpu')
                            <link itemprop="availability"
                                href="https://schema.org/{{ $ad->props['Availability'] == 'In stock' ? 'InStock' : 'PreOrder' }}" />
                            <link itemprop="itemCondition"
                                href="https://schema.org/{{ $ad->props['Condition'] == 'New' ? 'NewCondition' : 'UsedCondition' }}" />
                            <div itemprop="shippingDetails" itemscope
                                itemtype="https://schema.org/OfferShippingDetails">
                                <div itemprop="shippingRate" itemscope itemtype="https://schema.org/MonetaryAmount">
                                    <meta itemprop="value" content="0" />
                                    <meta itemprop="currency" content="RUB" />
                                </div>
                                <div itemprop="deliveryTime" itemscope
                                    itemtype="https://schema.org/ShippingDeliveryTime">
                                    <div itemprop="handlingTime" itemscope
                                        itemtype="https://schema.org/QuantitativeValue">
                                        <meta itemprop="minValue" content="0" />
                                        <meta itemprop="maxValue" content="1" />
                                        <meta itemprop="unitCode" content="d" />
                                    </div>
                                    <div itemprop="transitTime" itemscope
                                        itemtype="https://schema.org/QuantitativeValue">
                                        @if ($ad->props['Availability'] == 'In stock')
                                            <meta itemprop="minValue" content="0" />
                                            <meta itemprop="maxValue" content="3" />
                                            <meta itemprop="unitCode" content="d" />
                                        @else
                                            <meta itemprop="minValue"
                                                content="{{ $ad->props['Waiting (days)'] - round($ad->props['Waiting (days)'] / 5) }}" />
                                            <meta itemprop="maxValue" content="{{ $ad->props['Waiting (days)'] }}" />
                                            <meta itemprop="unitCode" content="d" />
                                        @endif
                                    </div>
                                </div>
                                <div itemprop="shippingDestination" itemscope
                                    itemtype="https://schema.org/DefinedRegion">
                                    <meta itemprop="addressCountry" content="RU" />
                                </div>
                            </div>

                            @if ($ad->props['Condition'] == 'New')
                                <div itemprop="hasMerchantReturnPolicy" itemscope
                                    itemtype="https://schema.org/MerchantReturnPolicy">
                                    <link itemprop="returnPolicyCategory"
                                        href="https://schema.org/MerchantReturnFiniteReturnWindow" />
                                    <link itemprop="returnMethod" href="https://schema.org/ReturnInStore" />
                                    <link itemprop="returnFees"
                                        href="https://schema.org/ReturnFeesCustomerResponsibility" />
                                    <link itemprop="refundType" href="https://schema.org/FullRefund" />
                                    <meta itemprop="applicableCountry" content="RU" />
                                    <meta itemprop="merchantReturnDays" content="14" />
                                </div>
                            @else
                                <div itemprop="hasMerchantReturnPolicy" itemscope
                                    itemtype="https://schema.org/MerchantReturnPolicy">
                                    <link itemprop="returnPolicyCategory"
                                        href="https://schema.org/MerchantReturnNotPermitted" />
                                    <meta itemprop="applicableCountry" content="RU" />
                                </div>
                            @endif
                        @endif

                        @if ($ad->price != 0)
                            <p class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200 flex items-center">
                                <meta itemprop="priceCurrency"
                                    content="{{ $ad->coin->abbreviation != 'USDT' ? $ad->coin->abbreviation : 'USD' }}" />
                                <span itemprop="price">{{ $ad->price }}</span>
                                <span class="ml-2">{{ $ad->coin->abbreviation }}</span>
                                <meta itemprop="valueAddedTaxIncluded"
                                    content="{{ $ad->with_vat ? 'true' : 'false' }}" />
                                @if ($ad->with_vat)
                                    <span
                                        class="ml-1 text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                                @endif

                                @if (
                                    $ad->adCategory->name == 'miners' &&
                                        data_get($ad, 'version_data.price_data.' . $ad->props['Condition'] . '.' . $ad->props['Availability'], null) !==
                                            null)
                                    @include('ad.components.price-graduation', [
                                        'priceData' =>
                                            $ad->version_data->price_data[$ad->props['Condition']][
                                                $ad->props['Availability']
                                            ],
                                    ])
                                @endif
                            </p>
                        @else
                            <div itemprop="priceSpecification" itemscope
                                itemtype="https://schema.org/PriceSpecification">
                                <meta itemprop="price" content="0" />
                                <meta itemprop="priceCurrency"
                                    content="{{ $ad->coin->abbreviation != 'USDT' ? $ad->coin->abbreviation : 'USD' }}" />
                                <meta itemprop="valueAddedTaxIncluded"
                                    content="{{ $ad->with_vat ? 'true' : 'false' }}" />
                                <p itemprop="description"
                                    class="mt-5 text-2xl font-semibold text-slate-800 dark:text-slate-200 flex items-center">
                                    {{ __('Price on request') }}
                                </p>
                            </div>
                        @endif

                        <a href="{{ route('company.office', ['user' => $ad->user->slug, 'office' => $ad->office->id]) }}"
                            target="_blank"
                            class="flex items-center hover:underline text-xxs xxs:text-xs sm:text-sm sm:text-base text-indigo-500 hover:text-indigo-600 mt-2 sm:mt-3 md:mt-4 lg:mt-6">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $ad->office->address }}
                        </a>

                        <x-characteristics.characteristics class="my-5 sm:my-6 lg:my-7">
                            @foreach ($ad->props as $prop => $value)
                                <x-characteristics.characteristic :name="$prop" :value="$value" />
                            @endforeach
                        </x-characteristics.characteristics>

                        <div>
                            @include('ad.components.about-seller', [
                                'user' => $ad->user,
                                'address' => [
                                    'city' => $ad->office->city,
                                    'street' => trim(
                                        implode(',', array_slice(explode(',', $ad->office->address), 2))),
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
                <div
                    class="mb-6 sm:mb-8 lg:mb-10 text-xs sm:text-sm text-center text-slate-600 border-b border-slate-300 dark:text-slate-400 dark:border-slate-800">
                    <ul class="flex flex-wrap -mb-px">
                        <li class="mr-0.5 sm:mr-2">
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'description'"
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
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'characteristics'"
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
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'reviews'"
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
                            <button class="inline-block p-1 xs:p-2 sm:p-3 lg:p-4 border-b-2 rounded-t-lg"
                                @click="selectedTab = 'location'"
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
                    @include('ad.components.can-trust')

                    @include('ad.components.description', ['description' => $ad->description])
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
                    @include('ad.components.location')
                </div>
            </div>
        </div>

        @if ($ad->adCategory->name == 'miners')
            @if (isset($ads))
                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                            {{ __('Other offers') }} {{ $ad->asicVersion->asicModel->name }}
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
            @endif

            @include('ad.components.faq')
        @endif
    </div>
</x-app-layout>
