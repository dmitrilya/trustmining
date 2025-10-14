<x-app-layout title="TrustMining: купить Asic майнер, майнинг хостинг" description="Сервис, объединивший в себе все сферы из мира майнинга. Информация по оборудованию для майнинга, новостной портал, блоггерское и экспертное сообщество, продавцы и специалисты">
    <x-slot name="header">
        @include('layouts.components.search')
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-8 lg:space-y-12">
        <div class="max-w-xs lg:max-w-xl mx-auto mt-4 md:mt-8">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">
                {{ __('Reducing the risks of investing in mining') }}</p>
        </div>

        <div class="max-w-sm md:max-w-4xl mx-auto">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-gray-400">
                {{ __('Every second miner has been scammed at least once. Every third has fallen for the tricks and often lost money irretrievably') }}
            </p>
        </div>

        <div class="grid gap-4 sm:gap-6 grid-cols-1 md:grid-cols-3">
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Hosting') }}</p>
                    <div class="flex items-center justify-center bg-gray-100 dark:bg-zinc-950 min-w-8 h-8 rounded-full">
                        <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Fake hostings that lure customers with favorable conditions') }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Miners') }}</p>
                    <div class="flex items-center justify-center bg-gray-100 dark:bg-zinc-950 min-w-8 h-8 rounded-full">
                        <svg class="h-4 w-4 text-gray-600 dark:text-gray-400" aria-hidden="true" fill="none"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1M5 12h14M5 12a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1m-2 3h.01M14 15h.01M17 9h.01M14 9h.01" />
                        </svg>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Counterfeit equipment that does not meet specifications or breaks down quickly') }}</p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Seller') }}</p>
                    <div class="flex items-center justify-center bg-gray-100 dark:bg-zinc-950 min-w-8 h-8 rounded-full">
                        <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" aria-hidden="true" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Disappearance of sellers after online payment for equipment') }}</p>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto">
            <p class="text-center text-xs sm:text-base text-gray-400">
                {{ __('If you or someone you know has experienced something like this, you know how risky investing in cryptocurrency mining can be') }}
            </p>
        </div>

        <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">
                {{ __('Solution from the TrustMining team') }}</p>
        </div>

        <div class="grid gap-4 sm:gap-6 grid-cols-1 md:grid-cols-3">
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Verification') }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Each seller must pass passport verification and confirm the presence of at least one point of sale') }}
                </p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">
                    {{ __('Availability of information') }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('The buyer can see all the information from offices to the official number of employees of the company') }}
                </p>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">Trust Factor</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('A unique metric of trust in a company') }}</p>
                <a href="#confidence-factor-info"
                    @click="event.preventDefault();document.querySelector(event.target.getAttribute('href')).scrollIntoView({behavior: 'smooth'});"
                    class="mt-2 md:mt-3 text-xxs sm:text-xs underline">{{ __('Details') }}</a>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
            <p class="text-center text-xs sm:text-base text-gray-400">
                *{{ __('The final decision is always yours. We cannot guarantee complete elimination of fraudulent attempts, but we implement all possible tools to minimize your risks') }}
            </p>
        </div>

        @include('layouts.components.search', [
            'border' => 'px-4 py-2.5 rounded-md border-2',
            'searchBlock' => 'max-w-lg mx-auto',
        ])

        <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">
                {{ __('Subscription') }}</p>
        </div>

        <div class="max-w-xl md:max-w-4xl mx-auto">
            <p class="text-center text-xs sm:text-lg lg:text-xl text-gray-400">
                {{ __('You can start using the service right now. All the tools you need are free, but for a symbolic subscription fee to support the development of the project, you will have access to several functions that will be useful if you regularly track the best prices on the market') }}
            </p>
        </div>

        @include('tariff.components.subscription')

        <div>
            <div id="confidence-factor-info" class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
                <p class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('Trust Factor') }}</p>
            </div>

            <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
                <p class="text-center text-xs sm:text-base text-gray-400">{{ __('What influences the Trust Factor') }}
                </p>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 md:p-7 rounded-2xl shadow-lg space-y-4">
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Registration of individual entrepreneur or LLC') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Duration of work since company registration') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Number of offices and points of sale') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <pp class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Official income of the company') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Registered employees') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Uniqueness of content') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Correctness of documents and contracts') }}</p>
            </div>
            {{-- <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Participation in conferences and mention in the media') }}</div>
            </div> --}}
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">
                    {{ __('Message response speed') }}</p>
            </div>
            <div class="flex items-center">
                <div
                    class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">
                    ✓</div>
                <p class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Reviews') }}</p>
            </div>
        </div>

        <div class="max-w-xl md:max-w-2xl mx-auto mt-4">
            <p class="text-center text-xs sm:text-base text-gray-400">
                {{ __('You can find this indicator in every advertisement for the sale of equipment or hosting, as well as in the company card') }}
            </p>
        </div>
    </div>
</x-app-layout>
