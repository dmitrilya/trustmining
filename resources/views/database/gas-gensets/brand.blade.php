<x-app-layout :title="'Газопоршневые электростанции от производителя ' . $brand->name"
    description="Газопоршневые электростанции от производителя {{ $brand->name }}. Цены, характеристики, реальные отзывы, фото. Каталог гпу.">
    <div class="max-w-7xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <x-breadcrumbs>
            <x-breadcrumb position="1" :href="route('database.gas-gensets')" :name="__('Gas gensets')" />
            <x-breadcrumb position="2" :name="$brand->name" />
        </x-breadcrumbs>

        <div class="bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 overflow-hidden shadow-sm shadow-logo-color rounded-lg p-4 md:p-6"
            x-data="{
                models: {{ $brand->gpuModels }},
                search: null,
                sortAsc: false,
                sortCol: null,
                sort(col, asc = true) {
                    if (this.sortCol === col) this.sortAsc = !this.sortAsc;
                    else this.sortAsc = asc;
                    this.sortCol = col;
                    this.models.sort((a, b) => {
                        if (a[this.sortCol] < b[this.sortCol]) return this.sortAsc ? 1 : -1;
                        if (a[this.sortCol] > b[this.sortCol]) return this.sortAsc ? -1 : 1;
                        return 0;
                    });
                },
            }">
            <div class="relative z-0 group ml-auto my-6">
                <input type="text" id="gpu-model_input" placeholder=" " x-model="search" autocomplete="off"
                    class="py-2.5 px-0 w-full max-w-56 text-sm text-slate-950 bg-transparent border-0 border-b-2 border-slate-300 appearance-none dark:text-white dark:border-slate-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                <label for="gpu-model_input"
                    class="flex items-center absolute text-sm text-slate-600 dark:text-slate-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    <svg class="w-3 h-3 mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                    </svg>
                    {{ __('Model') }}
                </label>
            </div>

            <div class="py-2 mb-2 grid grid-cols-4 gap-1 xs:gap-2 border-b border-slate-300 dark:border-slate-700">
                <div class="flex items-center cursor-pointer text-slate-600 text-xxs sm:text-xs sm:text-sm hover:text-slate-900 dark:hover:text-slate-200"
                    @click="sort('brand')">
                    {{ __('Brand') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex items-center cursor-pointer text-slate-600 text-xxs sm:text-xs sm:text-sm hover:text-slate-900 dark:hover:text-slate-200"
                    @click="sort('name')">
                    {{ __('Model') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex items-center cursor-pointer text-slate-600 text-xxs sm:text-xs sm:text-sm hover:text-slate-900 dark:hover:text-slate-200"
                    @click="sort('max_power')">
                    {{ __('Power') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="flex items-center cursor-pointer text-slate-600 text-xxs sm:text-xs sm:text-sm hover:text-slate-900 dark:hover:text-slate-200"
                    @click="sort('fuel_consumption')">
                    {{ __('Gas consumption') }}
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"class="ml-1 h-4 w-4">
                        <path
                            d="M4.93179 5.43179C4.75605 5.60753 4.75605 5.89245 4.93179 6.06819C5.10753 6.24392 5.39245 6.24392 5.56819 6.06819L7.49999 4.13638L9.43179 6.06819C9.60753 6.24392 9.89245 6.24392 10.0682 6.06819C10.2439 5.89245 10.2439 5.60753 10.0682 5.43179L7.81819 3.18179C7.73379 3.0974 7.61933 3.04999 7.49999 3.04999C7.38064 3.04999 7.26618 3.0974 7.18179 3.18179L4.93179 5.43179ZM10.0682 9.56819C10.2439 9.39245 10.2439 9.10753 10.0682 8.93179C9.89245 8.75606 9.60753 8.75606 9.43179 8.93179L7.49999 10.8636L5.56819 8.93179C5.39245 8.75606 5.10753 8.75606 4.93179 8.93179C4.75605 9.10753 4.75605 9.39245 4.93179 9.56819L7.18179 11.8182C7.35753 11.9939 7.64245 11.9939 7.81819 11.8182L10.0682 9.56819Z"
                            fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <template x-for="model in models" :key="model.id">
                <a :href="'/gas-gensets/' + model.brand_slug + '/' + model.slug"
                    class="py-1 sm:py-2 group rounded-md grid grid-cols-4 gap-1 xs:gap-2 items-center">
                    <div class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="model.brand_name"></div>
                    <h5 class="font-semibold text-slate-600 dark:text-slate-400 text-xxs sm:text-xs sm:text-sm group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="model.name">
                    </h5>
                    <div class="text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.max_power) + ' {{ __('kW/h') }}'"></div>
                    <div class="hidden sm:block text-slate-600 dark:text-slate-400 text-xxs sm:text-xs group-hover:text-slate-900 dark:group-hover:text-slate-200"
                        x-text="Math.round(model.fuel_consumption) + ' {{ __('m³/h') }}'"></div>
                </a>
            </template>
        </div>

        @foreach ($brand->gpuModels as $gpuModel)
            <a
                href="{{ route('database.gas-gensets.model', ['gpuBrand' => $brand->slug, 'gpuModel' => $gpuModel->slug]) }}"></a>
        @endforeach
    </div>
</x-app-layout>
