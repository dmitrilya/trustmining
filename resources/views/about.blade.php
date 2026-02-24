<x-app-layout title="TrustMining: купить Asic майнер, майнинг хостинг"
    description="Сервис, объединивший в себе все сферы из мира майнинга. Информация по оборудованию для майнинга, новостной портал, блоггерское и экспертное сообщество, продавцы и специалисты">
    {{-- <x-slot name="header">
        <div class="sm:mt-4 grid grid-cols-3 xs:grid-cols-4 sm:grid-cols-6 gap-3 sm:gap-4">
            @include('layouts.components.ad-categories')
        </div>
    </x-slot> --}}

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-8 lg:space-y-12">
        <div class="max-w-xs lg:max-w-xl mx-auto mt-4 md:mt-8">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-900 dark:text-gray-100 font-bold">
                <span>{{ __('Reducing the risks') }}</span><br />
                {{ __('of investing in mining') }}
            </p>
        </div>

        <div class="max-w-sm md:max-w-4xl mx-auto">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-gray-500">
                {{ __('Every second miner has been scammed at least once. Every third has fallen for the tricks and often lost money irretrievably') }}
            </p>
        </div>

        <div class="grid gap-4 sm:gap-6 lg:gap-10 xl:gap-14 grid-cols-1 md:grid-cols-3">
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">{{ __('Hosting') }}</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('Fake hostings that lure customers with favorable conditions') }}</p>
            </div>
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">{{ __('Miners') }}</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('Counterfeit equipment that does not meet specifications or breaks down quickly') }}</p>
            </div>
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">{{ __('Seller') }}</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('Disappearance of sellers after online payment for equipment') }}</p>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto">
            <p class="text-center text-xs sm:text-base text-gray-500">
                {{ __('If you or someone you know has experienced something like this, you know how risky investing in cryptocurrency mining can be') }}
            </p>
        </div>

        <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-900 dark:text-gray-100 font-bold">
                {{ __('Solution from the TrustMining team') }}</p>
        </div>

        <div class="grid gap-4 sm:gap-6 lg:gap-10 xl:gap-14 grid-cols-1 md:grid-cols-3">
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">{{ __('Verification') }}</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('Each seller must pass passport verification and confirm the presence of at least one point of sale') }}
                </p>
            </div>
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('Availability of information') }}</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('The buyer can see all the information from offices to the official number of employees of the company') }}
                </p>
            </div>
            <div
                class="p-6 md:p-7 rounded-xl hover:-translate-y-2 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-[0_0_30px_rgba(64,64,153,0.15)] dark:shadow-[0_0_40px_rgba(64,255,159,0.12)] hover:shadow-[0_0_30px_rgba(64,64,153,0.4)] dark:hover:shadow-[0_0_40px_rgba(64,255,159,0.35)]">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-bold">Trust Factor</p>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 mt-2 md:mt-3">
                    {{ __('A unique metric of trust in a company') }}</p>
                <a href="#confidence-factor-info"
                    @click="event.preventDefault();document.querySelector(event.target.getAttribute('href')).scrollIntoView({behavior: 'smooth'});"
                    class="mt-2 md:mt-3 text-xxs sm:text-xs underline text-indigo-600 dark:text-indigo-500">{{ __('Details') }}</a>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
            <p class="text-center text-xs sm:text-base text-gray-500">
                *{{ __('The final decision is always yours. We cannot guarantee complete elimination of fraudulent attempts, but we implement all possible tools to minimize your risks') }}
            </p>
        </div>

        @include('layouts.components.search', [
            'border' => 'px-4 py-2.5 rounded-md border-2',
            'searchBlock' => 'max-w-lg mx-auto',
        ])

        {{-- <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-900 dark:text-gray-100 font-bold">
                {{ __('Subscription') }}</p>
        </div>

        <div class="max-w-xl md:max-w-4xl mx-auto">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-gray-500">
                {{ __('You can start using the service right now. All the tools you need are free, but for a symbolic subscription fee to support the development of the project, you will have access to several functions that will be useful if you regularly track the best prices on the market') }}
            </p>
        </div>

        @include('tariff.components.subscription') --}}

        <div>
            <div id="confidence-factor-info" class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
                <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-900 dark:text-gray-100 font-bold">
                    {{ __('Trust Factor') }}</p>
            </div>

            <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
                <p class="text-center text-xs sm:text-base text-gray-500">{{ __('What influences the Trust Factor') }}
                </p>
            </div>
        </div>

        <div class="max-w-2xl mx-auto space-y-3">
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Official registration as an individual entrepreneur or legal entity') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Company operating period since official registration') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Number of active offices and sales locations') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Verified and declared company revenue') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Availability of officially employed staff') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Originality and quality of published content') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Accuracy and transparency of legal documentation') }}</p>
            </div>
            {{-- <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">{{ __('Participation in conferences and mention in the media') }}</div>
            </div> --}}
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Average response time to incoming inquiries') }}</p>
            </div>
            <div class="bg-white/30 dark:bg-white/10 px-4 py-3 sm:px-5 border-l-4 border-indigo-600 rounded-md">
                <p class="text-xs sm:text-sm lg:text-base text-gray-700 dark:text-gray-200">
                    {{ __('Quantity and quality of customer reviews') }}</p>
            </div>
        </div>

        <div class="max-w-xl md:max-w-2xl mx-auto mt-4">
            <p class="text-center text-xs sm:text-base text-gray-500">
                {{ __('You can find this indicator in every advertisement for the sale of equipment or hosting, as well as in the company card') }}
            </p>
        </div>
    </div>
</x-app-layout>
