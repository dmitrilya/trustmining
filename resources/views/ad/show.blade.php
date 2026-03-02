@php
    $user = Auth::user();
    $title =
        $ad->adCategory->name != 'gpus'
            ? ($ad->adCategory->name == 'miners'
                ? "{$ad->asicVersion->asicModel->asicBrand->name} {$ad->asicVersion->asicModel->name} {$ad->asicVersion->hashrate}{$ad->asicVersion->measurement} купить в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING"
                : "{$ad->adCategory->header} купить в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING")
            : "{$ad->gpuModel->gpuBrand->name} {$ad->gpuModel->name} {$ad->gpuModel->max_power}" .
                __('kW/h') .
                " купить в городе {$ad->office->city} у {$ad->user->name} по выгодной цене | TRUSTMINING";
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
@endphp

<x-app-layout :description="$description" :title="$title" :noindex="isset($moderation) ? 'true' : null">
    <x-slot name="og">
        <meta property="og:title" content="{{ $title }}">
        <meta property="og:description" content="{{ $description }}">
        <meta property="og:image" content="{{ Storage::disk('public')->url($ad->preview) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="product">
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 md:p-8">
        <nav class="mb-4 sm:mb-6" aria-label="Breadcrumb">
            <ol itemscope itemtype="https://schema.org/BreadcrumbList" role="list"
                class="flex items-center space-x-0.5 sm:space-x-2">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="1" />
                    <div class="flex items-center">
                        <a itemprop="item" href="{{ route('ads', ['adCategory' => $ad->adCategory->name]) }}"
                            class="sm:mr-2 text-xs xs:text-sm text-slate-900 dark:text-slate-100 hover:text-slate-900 dark:hover:text-slate-100">
                            <span itemprop="name">{{ __($ad->adCategory->header) }}</span>
                        </a>
                        @if ($ad->adCategory->name == 'miners' || $ad->adCategory->name == 'gpus')
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-slate-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        @endif
                    </div>
                </li>

                @if ($ad->adCategory->name == 'miners')
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('ads', ['adCategory' => $ad->adCategory->name, 'brands' => [strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->asicBrand->name))]]) }}"
                                class="sm:mr-2 text-xs xs:text-sm text-slate-900 dark:text-slate-100 hover:text-slate-900 dark:hover:text-slate-100">
                                <span itemprop="name">{{ $ad->asicVersion->asicModel->asicBrand->name }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-slate-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="3" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('ads', ['adCategory' => $ad->adCategory->name, 'model' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->name))]) }}"
                                class="sm:mr-2 text-xs xs:text-sm text-slate-900 dark:text-slate-100 hover:text-slate-900 dark:hover:text-slate-100">
                                <span itemprop="name">{{ $ad->asicVersion->asicModel->name }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-slate-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="4" />
                        <a itemprop="item" href="#" aria-current="page"
                            class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 hover:text-slate-600 dark:hover:text-slate-300">
                            <span
                                itemprop="name">{{ $ad->asicVersion->hashrate }}{{ $ad->asicVersion->measurement }}</span>
                        </a>
                    </li>
                @elseif ($ad->adCategory->name == 'gpus')
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="2" />
                        <div class="flex items-center">
                            <a itemprop="item"
                                href="{{ route('ads', ['adCategory' => $ad->adCategory->name, 'brands' => [strtolower(str_replace(' ', '_', $ad->gpuModel->gpuBrand->name))]]) }}"
                                class="sm:mr-2 text-xs xs:text-sm text-slate-900 dark:text-slate-100 hover:text-slate-900 dark:hover:text-slate-100">
                                <span itemprop="name">{{ $ad->gpuModel->gpuBrand->name }}</span>
                            </a>
                            <svg width="16" height="20" viewBox="0 0 16 20" fill="currentColor"
                                aria-hidden="true" class="h-5 w-3 sm:w-4 text-slate-400">
                                <path d="M5.697 4.34L8.98 16.532h1.327L7.025 4.341H5.697z" />
                            </svg>
                        </div>
                    </li>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="text-sm">
                        <meta itemprop="position" content="3" />
                        <a itemprop="item" href="#" aria-current="page"
                            class="text-xs xs:text-sm text-slate-600 dark:text-slate-300 hover:text-slate-600 dark:hover:text-slate-300">
                            <span itemprop="name">{{ $ad->gpuModel->name }}
                                {{ $ad->gpuModel->max_power }}{{ __('kW/h') }}</span>
                        </a>
                    </li>
                @endif
            </ol>
        </nav>

        @if (isset($moderation) && $user && in_array($user->role->name, ['admin', 'moderator']))
            @include('moderation.components.buttons', ['withUniqueCheck' => true])

            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6 mb-6">
                <div class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8">
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

                        <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => isset($moderation->data['office_id']) ? $moderation->data['office_id'] : $ad->office->id]) }}"
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
                                @include('components.about-seller', ['user' => $ad->user, 'auth' => $user])
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 md:col-span-12">
                        <div>
                            <h2 class="font-bold tracking-tight text-slate-950 dark:text-slate-100">
                                {{ __('Description') }}</h2>

                            <div itemprop="description"
                                class="ql-editor mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-950 dark:text-slate-100{{ isset($moderation->data['description']) ? ' border border-indigo-500' : '' }}">
                                {!! !isset($moderation->data['description'])
                                    ? (!$ad->description
                                        ? ($ad->adCategory->name == 'miners'
                                            ? $ad->asicVersion->asicModel->description
                                            : '')
                                        : $ad->description)
                                    : $moderation->data['description'] !!}
                            </div>

                            @if ($ad->adCategory->name == 'miners')
                                <a class="block mt-6"
                                    href="{{ route('database.model', [
                                        'asicBrand' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->asicBrand->name)),
                                        'asicModel' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->name)),
                                    ]) }}">
                                    <x-secondary-button>{{ __('More details about miner') }}</x-secondary-button>
                                </a>
                            @elseif ($ad->adCategory->name == 'gpus')
                                <a class="block mt-6"
                                    href="{{ route('database.gpu.model', [
                                        'gpuBrand' => strtolower(str_replace(' ', '_', $ad->gpuModel->gpuBrand->name)),
                                        'gpuModel' => strtolower(str_replace(' ', '_', $ad->gpuModel->name)),
                                    ]) }}">
                                    <x-secondary-button>{{ __('More details about gpu') }}</x-secondary-button>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div itemscope itemtype="https://schema.org/Product"
            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6">
            <meta itemprop="sku" content="{{ $ad->id }}">
            <meta itemprop="url" content="{{ url()->current() }}">
            <meta itemprop="description" content="{{ $description }}">
            <div
                class="mx-auto md:grid md:grid-cols-12 md:grid-rows-[auto,auto,1fr] md:gap-x-8 md:px-8 md:py-8 offer-card">
                <div class="md:col-span-5">
                    @if (!count($ad->images))
                        <div class="w-full overflow-hidden rounded-lg col-start-2">
                            <img itemprop="image" src="{{ Storage::url($ad->preview) }}" alt="{{ $alt }}"
                                class="w-full object-cover object-center">
                        </div>
                    @else
                        <x-carousel :images="array_merge([$ad->preview], $ad->images)"></x-carousel>
                    @endif
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
                            <meta itemprop="name"
                                content="{{ $ad->user->name }} {{ __($ad->adCategory->title) }}" />
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
                        @endif

                        <p class="mt-5 text-2xl font-semibold text-slate-950 dark:text-slate-50 flex items-center">
                            @if ($ad->price != 0)
                                <meta itemprop="priceCurrency"
                                    content="{{ $ad->coin->abbreviation != 'USDT' ? $ad->coin->abbreviation : 'USD' }}" />
                                <span itemprop="price">{{ $ad->price }}</span>
                                <span class="ml-2">{{ $ad->coin->abbreviation }}</span>

                                @if ($ad->adCategory->name == 'miners')
                                    @include('ad.components.price_graduation', [
                                        'priceData' =>
                                            $ad->version_data->price_data[$ad->props['Condition']][
                                                $ad->props['Availability']
                                            ],
                                    ])

                                    @include('ad.components.payback_info', [
                                        'profit' => $ad->version_data->profits[0]['profit'],
                                    ])
                                @endif
                                @if ($ad->with_vat)
                                    <span
                                        class="text-xs sm:text-sm lg:text-base">({{ __('The price includes VAT') }})</span>
                                @endif
                            @else
                                {{ __('Price on request') }}
                            @endif
                        </p>


                        <a href="{{ route('company.office', ['user' => $ad->user->url_name, 'office' => $ad->office->id]) }}"
                            target="_blank"
                            class="flex items-center hover:underline text-xxs xs:text-xs sm:text-sm sm:text-base text-indigo-600 hover:text-indigo-500 mt-2 sm:mt-3 md:mt-4">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" width="24" height="24"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M11.906 1.994a8.002 8.002 0 0 1 8.09 8.421 7.996 7.996 0 0 1-1.297 3.957.996.996 0 0 1-.133.204l-.108.129c-.178.243-.37.477-.573.699l-5.112 6.224a1 1 0 0 1-1.545 0L5.982 15.26l-.002-.002a18.146 18.146 0 0 1-.309-.38l-.133-.163a.999.999 0 0 1-.13-.202 7.995 7.995 0 0 1 6.498-12.518ZM15 9.997a3 3 0 1 1-5.999 0 3 3 0 0 1 5.999 0Z"
                                    clip-rule="evenodd" />
                            </svg>
                            {{ $ad->office->address }}
                        </a>

                        <div class="my-5">
                            <ul role="list" class="list-disc space-y-2 pl-4 text-xxs xs:text-xs sm:text-sm">
                                @if ($ad->adCategory->name == 'gpus')
                                    <li class="text-xxs xs:text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                        {{ __('Power (kW/h)') . ': ' }}
                                        <span
                                            class="text-slate-700 dark:text-slate-300">{{ __($ad->gpuModel->max_power) }}</span>
                                    </li>
                                @endif

                                @foreach ($ad->props as $prop => $value)
                                    <li class="text-xxs xs:text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                        {{ __($prop) . ': ' }}@if (!is_array($value))
                                            <span class="text-slate-700 dark:text-slate-300">{{ __($value) }}</span>
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
                            @include('ad.components.about-seller', ['user' => $ad->user])

                            @if ($user && $ad->user->id == $user->id)
                                @if (($lastM = $ad->moderations->reverse()->first()) && $lastM->moderation_status_id == 3)
                                    <div class="flex items-center mt-6">
                                        <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" aria-hidden="true"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                                        </svg>
                                        <p class="text-sm text-slate-500">
                                            {{ __('The ad did not pass moderation for the following reason:') }}</p>
                                    </div>
                                    <p class="mt-2 text-xxs xs:text-xs sm:text-sm text-slate-900 dark:text-slate-200">
                                        {{ $lastM->comment }}</p>
                                @endif

                                <a class="block mt-6" href="{{ route('ad.edit', ['ad' => $ad->id]) }}">
                                    <x-primary-button>{{ __('Edit') }}</x-primary-button>
                                </a>
                            @else
                                @php
                                    $trackClick =
                                        $user && $user->tariff
                                            ? 'axios.post("/ads/' .
                                                $ad->adCategory->name .
                                                '/' .
                                                $ad->id .
                                                '/track").then(r => {
                                                pushToastAlert(r.data.message, r.data.success ? "success" : "error");

                                                if (r.data.tracking) {
                                                    $el.closest(".offer-card").getElementsByClassName("tracking")[0].classList.remove("hidden");
                                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                                                __('Untrack price') .
                                                '";
                                                    ' .
                                                ($user->tg_id === null
                                                    ? 'if (!window.tgDontAsk) $dispatch("open-modal", "tg-auth");'
                                                    : '') .
                                                '
                                                } else {
                                                    $el.closest(".offer-card").getElementsByClassName("tracking")[0].classList.add("hidden");
                                                    $el.getElementsByTagName("span")[0].innerHTML = "' .
                                                __('Track price') .
                                                '";
                                                }
                                            })'
                                            : '$dispatch("open-modal", "need-subscription")';
                                @endphp

                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-6">
                                    <a class="block w-full sm:w-max" target="_blank"
                                        href="{{ route('chat.start', ['user' => $ad->user->id, 'ad_id' => $ad->id]) }}">
                                        <x-primary-button class="w-full flex items-center justify-center xs:py-3">
                                            <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24"
                                                height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="1.5"
                                                    d="M7 9h5m3 0h2M7 12h2m3 0h5M5 5h14a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-6.616a1 1 0 0 0-.67.257l-2.88 2.592A.5.5 0 0 1 8 18.477V17a1 1 0 0 0-1-1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                                            </svg>
                                            {{ __('Buy') }}
                                        </x-primary-button>
                                    </a>

                                    @if (count($ad->user->phones))
                                        <x-secondary-button
                                            class="w-full sm:w-max justify-center bg-secondary-gradient dark:text-slate-800 xs:py-3"
                                            x-data="{ number: null, status: '{{ __('View number') }}' }"
                                            @click="if (!number) axios.get('{{ route('phone.show', ['user' => $ad->user->id, 'ad_id' => $ad->id]) }}')
                                                .then(r => {
                                                    if (r.data.success) number = '+' + r.data.number;
                                                    else status = r.data.number;
                                                }); else window.open('tel:' + number);">
                                            <svg class="min-w-4 h-4 mr-1 xs:mr-2" width="24" height="24"
                                                fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z" />
                                            </svg>
                                            <span x-text="number ? number : status"></span>
                                        </x-secondary-button>
                                    @endif

                                    <x-secondary-button class="w-full sm:w-max justify-center xs:py-3"
                                        @click="{{ $trackClick }}">
                                        <svg class="min-w-4 h-4 mr-1 xs:mr-2" aria-hidden="true" width="24"
                                            height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 4.5V19a1 1 0 0 0 1 1h15M7 10l4 4 4-4 5 5m0 0h-3.207M20 15v-3.207" />
                                        </svg>
                                        <span>{{ $user && $user->trackedAds->where('id', $ad->id)->count() ? __('Untrack price') : __('Track price') }}</span>
                                    </x-secondary-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-8 md:col-span-12">
                    <div>
                        @if ($ad->description || ($ad->adcategory->name == 'miners' && $ad->asicVersion->asicModel->description))
                            <h2 class="font-bold tracking-tight text-slate-950 dark:text-slate-100">
                                {{ __('Description') }}</h2>

                            <div itemprop="description"
                                class="ql-editor mt-5 text-xxs xs:text-xs sm:text-sm sm:text-base text-slate-950 dark:text-slate-100">
                                {!! $ad->description ? $ad->description : $ad->asicVersion->asicModel->description !!}
                            </div>
                        @endif

                        @if ($ad->adCategory->name == 'miners')
                            <a class="block mt-6"
                                href="{{ route('database.model', [
                                    'asicBrand' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->asicBrand->name)),
                                    'asicModel' => strtolower(str_replace(' ', '_', $ad->asicVersion->asicModel->name)),
                                ]) }}">
                                <x-secondary-button>{{ __('More details about miner') }}</x-secondary-button>
                            </a>
                        @elseif ($ad->adCategory->name == 'gpus')
                            <a class="block mt-6"
                                href="{{ route('database.gpu.model', [
                                    'gpuBrand' => strtolower(str_replace(' ', '_', $ad->gpuModel->gpuBrand->name)),
                                    'gpuModel' => strtolower(str_replace(' ', '_', $ad->gpuModel->name)),
                                ]) }}">
                                <x-secondary-button>{{ __('More details about gpu') }}</x-secondary-button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if ($ad->adCategory->name == 'miners')
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
    </div>
</x-app-layout>
