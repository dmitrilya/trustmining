<x-app-layout :title="__('meta.hosting.show.title', ['name' => $hosting->user->name])" :description="__('meta.hosting.show.description', ['name' => $hosting->user->name, 'tariff' => collect($hosting->tariffs)->min('t')])">
    <x-slot name="og">
        <meta property="og:title" content="{{ __('meta.hosting.show.title', ['name' => $hosting->user->name]) }}">
        <meta property="og:description"
            content="{{ __('meta.hosting.show.description', ['name' => $hosting->user->name, 'tariff' => collect($hosting->tariffs)->min('t')]) }}">
        <meta property="og:image"
            content="{{ $hosting->user->company?->logo ? Storage::disk('public')->url($hosting->user->company->logo) : request()->getSchemeAndHttpHost() . '/img/icon.png' }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="product">
    </x-slot>

    <script src="https://api-maps.yandex.ru/v3/?apikey=edbdf37c-6677-43bf-8434-455e393b7362&lang=ru_RU"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    @php
        $auth = Auth::user();
    @endphp

    <div class="max-w-8xl mx-auto px-2 py-4 sm:p-4 lg:p-6">
        @if ($hosting->user->company)
            @include('shop.components.about')
        @endif

        <div class="xl:flex items-start gap-2 sm:gap-4">
            <div class="flex-1 min-w-0 xl:max-w-[calc(100%-336px)]">
                @if (isset($moderation))
                    @include('moderation.components.buttons')

                    @include('hosting.components.hosting', [
                        'isModeration' => true,
                        'isOwner' => $auth && $hosting->user->id == $auth->id,
                        'id' => $hosting->id,
                        'owner' => $hosting->user,
                        'images' => ['changed' => isset($moderation->data['images']), 'data' => $moderation->data['images'] ?? $hosting->images],
                        'peculiarities' => [
                            'changed' => isset($moderation->data['peculiarities']),
                            'data' => $moderation->data['peculiarities'] ?? $hosting->peculiarities,
                        ],
                        'address' => ['changed' => isset($moderation->data['address']), 'data' => $moderation->data['address'] ?? $hosting->address],
                        'tariffs' => ['changed' => isset($moderation->data['tariffs']), 'data' => $moderation->data['tariffs'] ?? $hosting->tariffs],
                        'conditions' => [
                            'changed' => isset($moderation->data['conditions']),
                            'data' => $moderation->data['conditions'] ?? $hosting->conditions,
                        ],
                        'expenses' => ['changed' => isset($moderation->data['expenses']), 'data' => $moderation->data['expenses'] ?? $hosting->expenses],
                        'contract' => ['changed' => isset($moderation->data['contract']), 'data' => $moderation->data['contract'] ?? $hosting->contract],
                        'territory' => [
                            'changed' => isset($moderation->data['territory']),
                            'data' => $moderation->data['territory'] ?? $hosting->territory,
                        ],
                        'energy_supply' => [
                            'changed' => isset($moderation->data['energy_supply']),
                            'data' => $moderation->data['energy_supply'] ?? $hosting->energy_supply,
                        ],
                        'video' => ['changed' => isset($moderation->data['video']), 'data' => $moderation->data['video'] ?? $hosting->video],
                        'description' => [
                            'changed' => isset($moderation->data['description']),
                            'data' => $moderation->data['description'] ?? $hosting->description,
                        ],
                    ])
                @endif

                @include('hosting.components.hosting', [
                    'isModeration' => false,
                    'isOwner' => $auth && $hosting->user->id == $auth->id,
                    'id' => $hosting->id,
                    'owner' => $hosting->user,
                    'images' => ['changed' => false, 'data' => $hosting->images],
                    'peculiarities' => ['changed' => false, 'data' => $hosting->peculiarities],
                    'address' => ['changed' => false, 'data' => $hosting->address],
                    'tariffs' => ['changed' => false, 'data' => $hosting->tariffs],
                    'conditions' => ['changed' => false, 'data' => $hosting->conditions],
                    'expenses' => ['changed' => false, 'data' => $hosting->expenses],
                    'contract' => ['changed' => false, 'data' => $hosting->contract],
                    'territory' => ['changed' => false, 'data' => $hosting->territory],
                    'energy_supply' => ['changed' => false, 'data' => $hosting->energy_supply],
                    'video' => ['changed' => false, 'data' => $hosting->video],
                    'description' => ['changed' => false, 'data' => $hosting->description],
                ])

                @if (\App\Enums\VotingCategory::best_hosting->validateCandidate($hosting->user))
                    <x-widjets.voting :category="\App\Enums\VotingCategory::best_hosting" :candidate="$hosting->user" type="block" />
                @endif

                @if ($hosting->user->is_anchor)
                    <x-widjets.your-company title="Is this your company's hosting?" class="p-2 sm:p-4 md:p-6 mt-2 sm:mt-4 xl:hidden" />
                @endif
            </div>

            <div x-data="{ isXL: window.matchMedia('(min-width: 1280px)').matches }" x-init="if (!isXL) window.initLazyComponent($data, '1280px')" class="hidden xl:flex flex-col gap-4 w-xs max-w-xs">
                <template x-if="isXL">
                    <div class="flex flex-col gap-4 w-full">
                        <div
                            class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-3">
                            <script src="https://trustmining.ru/build/assets/calculator-widjet.js" data-theme="dark" data-tariffs="{{ json_encode($hosting->tariffs) }}"
                                data-blocks="currency" data-model="antminer-l9" data-version="17"></script>
                        </div>

                        @if ($hosting->user->is_anchor)
                            <x-widjets.your-company title="Is this your company's hosting?" class="p-2 sm:p-3" />
                        @endif

                        <x-ai-kodex targetWidth="1280" />
                    </div>
                </template>
            </div>
        </div>

        @if (!isset($moderation))
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 mt-2 sm:mt-4">
                @include('company.components.tf')
            </div>
        @endif
    </div>
</x-app-layout>
