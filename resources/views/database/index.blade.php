<x-app-layout title="Каталог ASIC майнеров" description="ASIC майнеры. Цены, характеристики, расчет доходности, реальные отзывы, фото. Каталог моделей.">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6" x-data="{ search: '' }">
            <nav class="mb-3" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-2">
                    <li class="text-sm">
                        <div class="flex items-center">
                            <a href="#"
                                class="font-medium text-gray-500 hover:text-gray-600">{{ __('Catalog of models') }}</a>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="relative z-0 sm:max-w-xs group mb-6 ml-auto">
                <input type="text" id="asic-model_input" placeholder=" " @input="search = $el.value"
                    autocomplete="off" :value="search"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                <label for="asic-model_input"
                    class="flex items-center peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    <svg class="w-3 h-3 mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    {{ __('Brand') }}
                </label>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($brands as $brand)
                    <a x-data="{ name: '{{ $brand->name }}'.toLowerCase() }" x-show="name.includes(search.toLowerCase())"
                        href="{{ route('database.brand', ['asicBrand' => strtolower(str_replace(' ', '_', $brand->name))]) }}"
                        class="flex items-center px-3 py-2 group hover:bg-gray-200 rounded-md">
                        <img src="{{ Storage::url('public/brands/' . $brand->name . '.webp') }}"
                            alt="{{ $brand->name }}" class="w-5 sm:w-7 mr-2">
                        <h5 class="font-semibold text-gray-500 text-xs sm:text-sm group-hover:text-gray-900">
                            {{ $brand->name }}
                        </h5>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="mt-4 sm:mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-4 md:p-6"
            x-data="modelsData">
            <div
                class="grid grid-cols-2 xs:grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-1 sm:gap-2 md:mr-8">
                @foreach ($algos as $algo)
                    <div @click="algo && algo == '{{ $algo->name }}' ? filter(null, search) : filter('{{ $algo->name }}', search)"
                        class="flex items-center cursor-pointer px-2 py-1 xs:px-2 md:px-3 md:py-2 group sm:hover:bg-indigo-200 border sm:hover:border-indigo-500 rounded-md border-gray-300"
                        :class="{ 'border-indigo-500 bg-indigo-200': algo == '{{ $algo->name }}' }">
                        <img src="{{ Storage::url('public/coins/' . $algo->coins->first()->abbreviation . '.webp') }}"
                            alt="{{ $algo->coins->first()->abbreviation }}" class="w-4 sm:w-5 mr-2">
                        <h5 class="font-semibold text-gray-500 text-xxs sm:text-xs lg:text-sm sm:group-hover:text-indigo-500"
                            :class="{ 'text-indigo-500': algo == '{{ $algo->name }}' }">
                            {{ $algo->name }}
                        </h5>
                    </div>
                @endforeach
            </div>

            <div class="relative z-0 group ml-auto my-6">
                <input type="text" id="asic-model_input" placeholder=" " @input="filter(algo, $el.value)"
                    autocomplete="off" :value="search"
                    class="py-2.5 px-0 w-full max-w-56 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                <label for="asic-model_input"
                    class="flex items-center peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    <svg class="w-3 h-3 mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    {{ __('Model') }}
                </label>
            </div>

            <div
                class="py-2 mb-2 grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-8 xl:grid-cols-9 gap-1 xs:gap-2 border-b border-gray-200">
                <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900 col-span-2"
                    @click="sort('name')">
                    {{ __('Model') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('original_hashrate')">
                    {{ __('Hashrate') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="hidden sm:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('power')">
                    {{ __('Power') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="hidden md:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('release')">
                    {{ __('Release') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="hidden lg:flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('algorithm')">
                    {{ __('Algorithm') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="hidden xl:flex flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('original_efficiency', false)">j/Th
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex items-center cursor-pointer text-gray-500 text-xxs sm:text-xs sm:text-sm hover:text-gray-900"
                    @click="sort('profit')">
                    {{ __('Profit') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <template x-for="model in models" :key="model.name">
                <a :href="'/database/' + model.brand + '/' + model.url_name"
                    class="py-1 sm:py-2 group rounded-md grid grid-cols-5 sm:grid-cols-6 md:grid-cols-7 lg:grid-cols-8 xl:grid-cols-9 gap-1 xs:gap-2 items-center">
                    <h5 class="font-semibold text-gray-500 text-xxs sm:text-xs sm:text-sm group-hover:text-gray-900 col-span-2"
                        x-text="model.name">
                    </h5>
                    <div class="text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="(Math.round(model.hashrate * 1000) / 1000) + model.measurement + '/s'"></div>
                    <div class="hidden sm:block text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="Math.round(model.power) + ' {{ __('W') }}'"></div>
                    <div class="hidden md:block text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="new Date(model.release).toLocaleDateString(window.locale, {month: 'short', year: 'numeric'})">
                    </div>
                    <div class="hidden lg:block text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="model.algorithm"></div>
                    <div class="hidden xl:block text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="(Math.round(model.original_efficiency * 10000) / 10000) + 'j/' + model.original_measurement">
                    </div>
                    <div class="text-gray-500 text-xxs sm:text-xs group-hover:text-gray-900"
                        x-text="model.profit + ' {{ __('USDT') }}'">
                    </div>
                    <div class="pl-1.5 sm:pl-2">
                        <template x-for="coin in model.coins" :key="model.name + coin">
                            <img class="min-w-3 h-3 sm:min-w-4 sm:h-4 -ml-1.5 sm:-ml-2 inline" :src="'/storage/coins/' + coin + '.webp'" :alt="coin">
                        </template>
                    </div>
                </a>
            </template>
        </div>
    </div>
</x-app-layout>
