<x-app-layout>
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
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Hosting') }}</div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Fake hostings that lure customers with favorable conditions') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Miners') }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Counterfeit equipment that does not meet specifications or breaks down quickly') }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Seller') }}</p>
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
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Verification') }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('Each seller must pass passport verification and confirm the presence of at least one point of sale') }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <p class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">
                    {{ __('Availability of information') }}</p>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">
                    {{ __('The buyer can see all the information from offices to the official number of employees of the company') }}
                </p>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
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

        @include('layouts.components.search', ['border' => 'px-4 py-2.5 rounded-md border-2', 'searchBlock' => 'max-w-lg mx-auto'])

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

        <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-2xl shadow-lg space-y-4">
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
