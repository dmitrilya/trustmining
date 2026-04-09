@php
    $user = Auth::user();
    $title =
        $ad->adCategory->name != 'gpus'
            ? ($ad->adCategory->name == 'miners'
                ? "Купить {$ad->asicVersion->asicModel->asicBrand->name} {$ad->asicVersion->asicModel->name} {$ad->asicVersion->hashrate}{$ad->asicVersion->measurement} в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING"
                : "{$ad->adCategory->header} купить в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING")
            : "Купить {$ad->gpuModel->gpuBrand->name} {$ad->gpuModel->name} {$ad->gpuModel->max_power}" .
                __('kW/h') .
                " в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING";
    $description =
        $ad->adCategory->name != 'gpus'
            ? ($ad->adCategory->name == 'miners'
                ? 'Купите ' .
                    ($ad->props['Condition'] == 'New' ? 'новый' : 'б/у') .
                    " ASIC {$ad->asicVersion->asicModel->asicBrand->name} {$ad->asicVersion->asicModel->name} {$ad->asicVersion->hashrate}{$ad->asicVersion->measurement} в городе {$ad->office->city} у {$ad->user->name}. " .
                    ($ad->props['Availability'] == 'Preorder' ? 'Под заказ' : 'В наличии') .
                    ' с доставкой по РФ. Смотрите фото, характеристики и отзывы на TRUSTMINING'
                : "Купите {$ad->adCategory->header} в городе {$ad->office->city} у компании {$ad->user->name}. Доставка по всей России. Фото, характеристики, отзывы")
            : 'Купите ' .
                ($ad->props['Condition'] == 'New' ? 'новый' : 'б/у') .
                " ГПЭС/ГПУ {$ad->gpuModel->gpuBrand->name} {$ad->gpuModel->name} {$ad->gpuModel->max_power}" .
                __('kW/h') .
                " в городе {$ad->office->city} у {$ad->user->name}. " .
                ($ad->props['Availability'] == 'Preorder' ? 'Под заказ' : 'В наличии') .
                ' с доставкой по РФ. Смотрите фото, характеристики и отзывы на TRUSTMINING';
    $alt =
        $ad->adCategory->name != 'gpus'
            ? ($ad->adCategory->name == 'miners'
                ? "{$ad->asicVersion->asicModel->name} {$ad->asicVersion->hashrate}{$ad->asicVersion->measurement} купить у {$ad->user->name}"
                : "{$ad->adCategory->header} купить в у {$ad->user->name}")
            : "{$ad->gpuModel->gpuBrand->name} {$ad->gpuModel->name} {$ad->gpuModel->max_power}" .
                __('kW/h') .
                " купить у {$ad->user->name}";
    $href =
        $ad->adCategory->name == 'miners'
            ? route('ads.asic.show', [
                'asicBrand' => $ad->asicVersion->asicModel->asicBrand->slug,
                'asicModel' => $ad->asicVersion->asicModel->slug,
                'asicVersion' => $ad->asicVersion->hashrate . $ad->asicVersion->measurement,
                'ad' => $ad->user->slug . '-' . $ad->id,
            ])
            : ($ad->adCategory->name == 'gpus'
                ? route('ads.gpu.show', [
                    'gpuBrand' => $ad->gpuModel->gpuBrand->slug,
                    'gpuModel' => $ad->gpuModel->slug,
                    'ad' => $ad->user->slug . '-' . $ad->id,
                ])
                : route('ads.show', ['adCategory' => $ad->adCategory->name, 'ad' => $ad->id]));
@endphp

<x-app-layout :description="$description" :title="$title" :noindex="isset($moderation) ? 'true' : null" :canonical="$href">
    <x-slot name="og">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ Storage::disk('public')->url($ad->preview) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="product">
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 md:p-8">
        @include('ad.components.breadcrumbs')

        @if (isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons', ['withUniqueCheck' => true])

            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6 lg:p-14">
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
                        @if ($ad->adCategory->name == 'miners')
                            <h1
                                class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                                {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
                            </h1>
                        @elseif ($ad->adCategory->name == 'gpus')
                            <h1
                                class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                                {{ $ad->gpuModel->gpuBrand->name . ' ' . $ad->gpuModel->name }}
                            </h1>
                        @endif

                        <p
                            class="mt-5 text-2xl font-semibold text-slate-950 dark:text-slate-50{{ isset($moderation->data['price']) ? ' border border-indigo-500' : '' }}">
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
                            class="flex items-center hover:underline text-xxs xs:text-xs sm:text-sm sm:text-base text-indigo-600 hover:text-indigo-500 mt-2 sm:mt-3 md:mt-4{{ isset($moderation->data['office_id']) ? ' border border-indigo-500' : '' }}">
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
                            <div class="my-5">
                                <ul role="list" class="list-disc space-y-2 pl-4 text-xxs xs:text-xs sm:text-sm">
                                    @if ($ad->adCategory->name == 'gpus')
                                        <li class="text-xxs xs:text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                            {{ __('Power (kW/h)') . ': ' }}
                                            <span
                                                class="text-slate-700 dark:text-slate-300">{{ __($ad->gpuModel->max_power) }}</span>
                                        </li>
                                    @endif

                                    @foreach ($props as $prop => $value)
                                        <li class="text-xxs xs:text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                            {{ __($prop) . ': ' }}@if (!is_array($value))
                                                <span
                                                    class="text-slate-700 dark:text-slate-300">{{ __($value) }}</span>
                                            @else
                                                <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                                                    @foreach ($value as $item)
                                                        <div
                                                            class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
                                                            {{ $item }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

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

                <div class="mt-8">
                    @if (!isset($moderation->data['description']))
                        @include('ad.components.description', [
                            'description' => $moderation->data['description'],
                        ])
                    @endif
                </div>
            </div>
        @endif

        <div itemscope itemtype="https://schema.org/Product"
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 lg:p-14">
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
                        @if (!count($ad->images))
                            <div class="w-full aspect-[4/3] rounded-lg col-start-2">
                                <img itemprop="image" src="{{ Storage::url($ad->preview) }}" alt="{{ $alt }}"
                                    class="w-full rounded-lg object-cover object-center">
                            </div>
                        @else
                            <x-carousel :images="array_merge([$ad->preview], $ad->images)"></x-carousel>
                        @endif

                        @include('ad.components.characteristics')
                    </div>
                </div>

                <div
                    class="mt-4 sm:mt-8 md:mt-0 md:col-span-7 md:border-l border-slate-300 dark:border-slate-700 md:pl-8">
                    <div class="flex items-start justify-between">
                        @if ($ad->adCategory->name == 'miners')
                            <meta itemprop="brand" content="{{ $ad->asicVersion->asicModel->asicBrand->name }}" />
                            <h1 itemprop="name"
                                class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                                {{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}
                            </h1>
                        @elseif ($ad->adCategory->name == 'gpus')
                            <meta itemprop="brand" content="{{ $ad->gpuModel->gpuBrand->name }}" />
                            <meta itemprop="name" content="{{ $ad->gpuModel->name }}" />
                            <h1
                                class="text-xl font-bold tracking-tight text-slate-950 dark:text-slate-100 sm:text-2xl md:text-3xl">
                                {{ $ad->gpuModel->gpuBrand->name . ' ' . $ad->gpuModel->name }}
                            </h1>
                        @else
                            <meta itemprop="name" content="{{ $ad->user->name }} {{ __($ad->adCategory->title) }}" />
                        @endif

                        <div
                            class="bg-slate-100 dark:bg-slate-950 rounded-full ml-3 p-1.5 sm:p-2 lg:p-2.5 tracking{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? '' : ' hidden' }}">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6 text-indigo-600" aria-hidden="true"
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

                        <p class="mt-5 text-2xl font-semibold text-slate-950 dark:text-slate-50 flex items-center">
                            @if ($ad->price != 0)
                                <meta itemprop="priceCurrency"
                                    content="{{ $ad->coin->abbreviation != 'USDT' ? $ad->coin->abbreviation : 'USD' }}" />
                                <span itemprop="price">{{ $ad->price }}</span>
                                <span class="ml-2">{{ $ad->coin->abbreviation }}</span>
                                @if ($ad->with_vat)
                                    <span
                                        class="ml-1 text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                                @endif

                                @if ($ad->adCategory->name == 'miners' && $ad->version_data)
                                    @include('ad.components.price_graduation', [
                                        'priceData' =>
                                            $ad->version_data->price_data[$ad->props['Condition']][
                                                $ad->props['Availability']
                                            ],
                                    ])
                                @endif
                            @else
                                {{ __('Price on request') }}
                            @endif
                        </p>

                        <a href="{{ route('company.office', ['user' => $ad->user->slug, 'office' => $ad->office->id]) }}"
                            target="_blank"
                            class="flex items-center hover:underline text-xxs xs:text-xs sm:text-sm sm:text-base text-indigo-600 hover:text-indigo-500 mt-2 sm:mt-3 md:mt-4 lg:mt-5">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $ad->office->address }}
                        </a>

                        <x-characteristics class="my-5 sm:my-6 lg:my-7">
                            @foreach ($ad->props as $prop => $value)
                                <x-characteristic :name="$prop" :value="$value" />
                            @endforeach
                        </x-characteristics>

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

            <div class="mt-8">
                @include('ad.components.description', ['description' => $ad->description])

                @include('ad.components.can_trust')
            </div>
        </div>

        @if ($ad->adCategory->name == 'miners')
            @if (isset($ads))
                <section class="mt-4 sm:mt-6 lg:mt-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
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
