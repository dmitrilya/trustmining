<x-app-layout>
    <x-slot name="header">
        <div class="relative w-full max-w-md" x-data="{ open: false, sugs: false }" @click.away="open = false">
            <div class="relative z-0 w-full group" @click="open = true">
                <input type="text"
                    placeholder="{{ __('Find a miner, company or article...') }}"
                    @input.debounce.1000ms="sugs = search($el.value, $refs.suggestionList, open)" autocomplete="off"
                    class="block py-2.5 px-0 w-full text-sm placeholder:text-xs sm:placeholder:text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-gray-800 focus:outline-none focus:ring-0 focus:border-gray-800 peer" />
            </div>

            <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            </ul>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8 space-y-8 lg:space-y-12">
        <div class="max-w-xs lg:max-w-xl mx-auto mt-4 md:mt-8">
            <div class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">{{ __('Reducing the risks of investing in mining') }}</div>
        </div>

        <div class="max-w-sm md:max-w-4xl mx-auto">
            <div class="text-center text-xs sm:text-lg lg:text-xl text-gray-400">{{ __('Every second miner has been scammed at least once. Every third has fallen for the tricks and often lost money irretrievably') }}</div>
        </div>

        <div class="grid gap-4 sm:gap-6 grid-cols-1 md:grid-cols-3">
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Hosting') }}</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('Fake hostings that lure customers with favorable conditions') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Miners') }}</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('Counterfeit equipment that does not meet specifications or breaks down quickly') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Seller') }}</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('Disappearance of sellers after online payment for equipment') }}</div>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto">
            <div class="text-center text-xs sm:text-base text-gray-400">{{ __('If you or someone you know has experienced something like this, you know how risky investing in cryptocurrency mining can be') }}</div>
        </div>

        <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <div class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">{{ __('Solution from the TrustMining team') }}</div>
        </div>

        <div class="grid gap-4 sm:gap-6 grid-cols-1 md:grid-cols-3">
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Verification') }}</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('Each seller must pass passport verification and confirm the presence of at least one point of sale') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">{{ __('Availability of information') }}</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('The buyer can see all the information from offices to the official number of employees of the company') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-xl shadow-lg">
                <div class="text-sm sm:text-lg text-gray-700 dark:text-gray-300 font-bold">Trust Factor</div>
                <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 md:mt-3">{{ __('A unique metric of trust in a company') }}</div>
                <a href="#confidence-factor-info" @click="event.preventDefault();document.querySelector(event.target.getAttribute('href')).scrollIntoView({behavior: 'smooth'});" class="mt-2 md:mt-3 text-xxs sm:text-xs underline">{{ __('Details') }}</a>
            </div>
        </div>

        <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
            <div class="text-center text-xs sm:text-base text-gray-400">*{{ __('The final decision is always yours. We cannot guarantee complete elimination of fraudulent attempts, but we implement all possible tools to minimize your risks') }}</div>
        </div>

        <div class="relative w-full max-w-md mx-auto" x-data="{ open: false, sugs: false }" @click.away="open = false">
            <div class="relative z-0 w-full group" @click="open = true">
                <input type="text"
                    placeholder="{{ __('Find a miner, company or article...') }}"
                    @input.debounce.1000ms="sugs = search($el.value, $refs.suggestionList, open)" autocomplete="off"
                    class="block py-2.5 px-4 rounded-md w-full placeholder:text-xs sm:placeholder:text-sm text-sm placeholder:text-gray-500 text-gray-900 bg-transparent border-2 border-gray-300 appearance-none dark:text-white dark:placeholder:text-gray-300 dark:border-gray-600 dark:focus:border-gray-800 focus:outline-none focus:ring-0 focus:border-gray-800 peer" />
            </div>

            <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
            </ul>
        </div>

        <div class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
            <div class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">{{ __('Subscription') }}</div>
        </div>

        <div class="max-w-xl md:max-w-4xl mx-auto">
            <div class="text-center text-xs sm:text-lg lg:text-xl text-gray-400">{{ __('You can start using the service right now. All the tools you need are free, but for a symbolic subscription fee to support the development of the project, you will have access to several functions that will be useful if you regularly track the best prices on the market') }}</div>
        </div>

        @include('tariff.components.subscription')

        <div>
            <div id="confidence-factor-info" class="max-w-sm lg:max-w-xl mx-auto pt-12 md:pt-16">
                <div class="text-center text-2xl sm:text-3xl lg:text-5xl text-gray-800 dark:text-gray-200 font-bold">{{ __('Trust Factor') }}</div>
            </div>

            <div class="max-w-sm md:max-w-2xl mx-auto mt-4">
                <div class="text-center text-xs sm:text-base text-gray-400">{{ __('What influences the Trust Factor') }}</div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 p-6 md:p-7 rounded-2xl shadow-lg space-y-4">
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Registration of individual entrepreneur or LLC') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Duration of work since company registration') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Number of offices and points of sale') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Official income of the company') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Registered employees') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Uniqueness of content') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Correctness of documents and contracts') }}</div>
            </div>
            {{-- <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Participation in conferences and mention in the media') }}</div>
            </div> --}}
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Message response speed') }}</div>
            </div>
            <div class="flex items-center">
                <div class="me-3 sm:me-4 flex items-center justify-center text-xs sm:text-lg text-white bg-[#40ff9f]/90 shadow-md min-w-5 h-5 sm:min-w-8 sm:h-8 rounded-full">✓</div>
                <div class="text-xs sm:text-sm lg:text-base text-gray-600 dark:text-gray-300">{{ __('Reviews') }}</div>
            </div>
        </div>

        <div class="max-w-xl md:max-w-2xl mx-auto mt-4">
            <div class="text-center text-xs sm:text-base text-gray-400">{{ __('You can find this indicator in every advertisement for the sale of equipment or hosting, as well as in the company card') }}</div>
        </div>
    <div>
</x-app-layout>
