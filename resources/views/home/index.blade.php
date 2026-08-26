<x-home-layout :data="$__data" title="TrustMining: купить Asic майнер, майнинг хостинг"
    description="Сервис, объединивший в себе все сферы из мира майнинга. Информация по оборудованию для майнинга, новостной портал, блоггерское и экспертное сообщество, продавцы и специалисты">
    <div class="lg:hidden mb-4 sm:mb-6">
        @include('home.components.asic-brands')
    </div>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Miners') }}
            </h2>
        </div>

        <div>
            <x-carousel.carousel :items="$miners" blade="ad.components.card" model="ad" :sm="true" />
        </div>
    </section>

    <div class="lg:hidden mb-4 sm:mb-6">
        @include('home.components.last-forum-questions')
    </div>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Hostings') }}
            </h2>
        </div>

        <div>
            <x-carousel.carousel :items="$hostings" blade="hosting.components.card" model="hosting" />
        </div>
    </section>

    <div class="lg:hidden mb-4 sm:mb-6">
        @include('home.components.top-channels')
    </div>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Gas generators') }}
            </h2>
        </div>

        <div>
            <x-carousel.carousel :items="$gpuModels" blade="database.components.gpu-card" model="gpu" />
        </div>
    </section>

    <section class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex items-center justify-between px-4 py-1.5 lg:px-5 lg:py-2 gap-4 mb-2 sm:mb-3">
            <h2 class="font-extrabold text-xl sm:text-2xl text-slate-800 dark:text-slate-200">
                {{ __('Articles') }}
            </h2>
        </div>

        <div>
            <x-carousel.carousel :items="$articles" blade="insight.article.components.card" model="article" />
        </div>
    </section>
</x-home-layout>
