<x-app-layout :title="__('meta.company.show.title', ['name' => $company->name])" :description="__('meta.company.show.description', ['name' => $company->name])">
    <script src="https://api-maps.yandex.ru/v3/?apikey=edbdf37c-6677-43bf-8434-455e393b7362&lang=ru_RU"></script>

    @php
        $auth = Auth::user();
        $user = $company->user;
        $card = $company->card;
    @endphp

    <div class="max-w-7xl mx-auto px-2 sm:px-6 md:px-8 py-8">
        @include('shop.components.about')

        @if (isset($moderation))
            @include('moderation.components.buttons')

            @include('company.components.company', [
                'isModeration' => true,
                'images' => ['changed' => isset($moderation->data['images']), 'data' => $moderation->data['images'] ?? $company->images],
                'documents' => ['changed' => isset($moderation->data['documents']), 'data' => $moderation->data['documents'] ?? $company->documents],
                'video' => ['changed' => isset($moderation->data['video']), 'data' => $moderation->data['video'] ?? $company->video],
                'logo' => ['changed' => isset($moderation->data['logo']), 'data' => $moderation->data['logo'] ?? $company->logo],
                'bg_logo' => ['changed' => isset($moderation->data['bg_logo']), 'data' => $moderation->data['bg_logo'] ?? $company->bg_logo],
                'site' => ['changed' => isset($moderation->data['site']), 'data' => $moderation->data['site'] ?? $company->site],
            ])
        @endif

        @if (!isset($moderation))
            <div
                class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow shadow-logo-color rounded-xl p-2 sm:p-4 md:p-6 lg:p-8 xl:p-10">
                @include('company.components.tf')
            </div>
        @endif

        @include('company.components.company', [
            'isModeration' => false,
            'images' => ['changed' => false, 'data' => $company->images],
            'documents' => ['changed' => false, 'data' => $company->documents],
            'video' => ['changed' => false, 'data' => $company->video],
        ])
    </div>
</x-app-layout>
