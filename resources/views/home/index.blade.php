<x-app-layout title="TrustMining: купить Asic майнер, майнинг хостинг"
    description="Сервис, объединивший в себе все сферы из мира майнинга. Информация по оборудованию для майнинга, новостной портал, блоггерское и экспертное сообщество, продавцы и специалисты">
    {{-- <x-slot name="header">
        <div class="sm:mt-4 grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-6 gap-3 sm:gap-4">
            @include('layouts.components.ad-categories')
        </div>
    </x-slot> --}}

    <div class="max-w-10xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="lg:grid grid-cols-12 gap-4 items-start relative">
            <div class="hidden lg:flex flex-col lg:col-span-3 xl:col-span-2 gap-4">
                @include('home.components.categories')
                @include('insight.components.popular-article')
                @include('home.components.top-channels')
            </div>

            <div class="lg:col-span-6 xl:col-span-7">
                <div class="lg:hidden mb-4 sm:mb-6">
                    @include('home.components.asic-brands')
                </div>

                <section class="mb-4 sm:mb-6 lg:mb-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                            {{ __('Miners') }}
                        </h2>
                    </div>

                    <div>
                        @include('home.components.carousel', [
                            'items' => $miners,
                            'blade' => 'ad.components.card',
                            'model' => 'ad',
                            'sm' => true,
                        ])
                    </div>
                </section>

                <div class="lg:hidden mb-4 sm:mb-6">
                    @include('home.components.last-forum-questions')
                </div>

                <section class="mb-4 sm:mb-6 lg:mb-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                            {{ __('Hostings') }}
                        </h2>
                    </div>

                    <div>
                        @include('home.components.carousel', [
                            'items' => $hostings,
                            'blade' => 'hosting.components.card',
                            'model' => 'hosting',
                        ])
                    </div>
                </section>

                <div class="lg:hidden mb-4 sm:mb-6">
                    @include('home.components.top-channels')
                </div>

                <section class="mb-4 sm:mb-6 lg:mb-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                            {{ __('Gas gensets') }}
                        </h2>
                    </div>

                    <div>
                        @include('home.components.carousel', [
                            'items' => $gpuModels,
                            'blade' => 'database.components.gpu-card',
                            'model' => 'gpu',
                        ])
                    </div>
                </section>

                <section class="mb-4 sm:mb-6 lg:mb-8">
                    <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
                        <h2 class="font-bold text-xl sm:text-2xl text-slate-900 dark:text-slate-100">
                            {{ __('Articles') }}
                        </h2>
                    </div>

                    <div>
                        @include('home.components.carousel', [
                            'items' => $articles,
                            'blade' => 'insight.article.components.card',
                            'model' => 'article',
                        ])
                    </div>
                </section>
            </div>

            <div class="hidden lg:flex flex-col lg:col-span-3 gap-4">
                @include('home.components.asic-models')
                @include('home.components.asic-brands')
                @include('home.components.last-forum-questions')

                @if (isset($sidebar))
                    {{ $sidebar }}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
