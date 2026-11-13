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

    <div class="max-w-8xl mx-auto px-2 py-4 sm:p-6 md:p-8">
        @include('ad.components.breadcrumbs')

        <div class="xl:flex items-start gap-4">
            <div class="flex-1 min-w-0 xl:max-w-[calc(100%-336px)]">
                @if (isset($moderation))
                    @include('moderation.components.buttons', ['withUniqueCheck' => true])

                    @include('ad.components.ad', [
                        'isModeration' => true,
                        'preview' => ['changed' => isset($moderation->data['preview']), 'data' => $moderation->data['preview'] ?? $ad->preview],
                        'images' => ['changed' => isset($moderation->data['images']), 'data' => $moderation->data['images'] ?? $ad->images],
                        'price' => ['changed' => isset($moderation->data['price']), 'data' => $moderation->data['price'] ?? $ad->price],
                        'coin' => [
                            'changed' => isset($moderation->data['coin_Id']),
                            'data' => isset($moderation->data['coin_Id'])
                                ? DB::table('coins')->where('id', $moderation->data['coin_id'])->first('abbreviation')->abbreviation
                                : $ad->coin->abbreviation,
                        ],
                        'with_vat' => ['changed' => isset($moderation->data['with_vat']), 'data' => $moderation->data['with_vat'] ?? $ad->with_vat],
                        'props' => ['changed' => isset($moderation->data['props']), 'data' => $moderation->data['props'] ?? $ad->props],
                        'adDescription' => [
                            'changed' => isset($moderation->data['description']),
                            'data' => $moderation->data['description'] ?? $ad->description,
                        ],
                    ])
                @endif

                @include('ad.components.ad', [
                    'isModeration' => false,
                    'preview' => ['changed' => false, 'data' => $ad->preview],
                    'images' => ['changed' => false, 'data' => $ad->images],
                    'price' => ['changed' => false, 'data' => $ad->price],
                    'coin' => ['changed' => false, 'data' => $ad->coin->abbreviation],
                    'with_vat' => ['changed' => false, 'data' => $ad->with_vat],
                    'props' => ['changed' => false, 'data' => $ad->props],
                    'adDescription' => ['changed' => false, 'data' => $ad->description],
                ])

                @if (!isset($moderation))
                    @if ($ad->user->is_anchor)
                        <x-widjets.your-company title="Is this an ad for your company?" class="p-2 sm:p-4 md:p-6 lg:p-14 mt-2 sm:mt-4 xl:hidden" />
                    @endif

                    <div
                        class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-14 mt-2 sm:mt-4">
                        @include('company.components.tf')
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
                                    <x-carousel.carousel :items="$ads" blade="ad.components.card" model="ad" :big="true" />
                                </div>
                            </section>
                        @endif

                        @include('ad.components.faq')
                    @endif
                @endif
            </div>

            <div x-data="{ isXL: window.matchMedia('(min-width: 1280px)').matches }" x-init="if (!isXL) window.initLazyComponent($data, '1280px')" class="hidden xl:flex flex-col gap-4 w-xs max-w-xs">
                <template x-if="isXL">
                    <div class="flex flex-col gap-4 w-full">
                        @if ($ad->adCategory->name == 'miners')
                            <div
                                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-3">
                                <script src="https://trustmining.ru/build/assets/calculator-widjet.js" data-theme="dark" data-blocks="additional-params,currency,coins"
                                    data-model="{{ $ad->asicVersion->asicModel->slug }}" data-version="{{ $ad->asicVersion->hashrate }}"></script>
                            </div>
                        @endif

                        @if ($ad->user->is_anchor)
                            <x-widjets.your-company title="Is this an ad for your company?" class="p-2 sm:p-3" />
                        @endif

                        <x-ai-kodex targetWidth="1280" />
                    </div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>
