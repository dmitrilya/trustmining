<div x-data="{
    models: Object.freeze({{ $gpuModels }}),
    selectedModel: {{ isset($selectedModel) ? $selectedModel : 'null' }},
    search: '{{ isset($selectedModel) ? $selectedModel->name : '' }}',
    openDropdown: null
}">
    <input class="block h-0 p-0 border-0" type="text" :value="selectedModel?.slug" name="gpu_model"
        @if (isset($required)) required @endif aria-label="{{ __('Model') }}">

    <div>
        <div class="relative mt-1" x-data="{ open: false }" @click.away="open = false">
            <div class="relative z-0 w-full" @click="open = true">
                <div class="flex items-center justify-between group border-b-2 border-slate-300 dark:border-slate-700">
                    <input type="text" autocomplete="off" :value="search" id="search_model"
                        @input="search = $el.value;selectedModel = null"
                        class="block py-2.5 px-0 w-full text-sm text-slate-950 bg-transparent border-0 appearance-none dark:text-white group-focus:outline-none focus:ring-0 peer" />

                    <button type="button" aria-label="Clear"
                        class="ml-4 flex h-4 w-4 items-center justify-center rounded-md text-slate-500 dark:text-slate-400"
                        @click="search = '';selectedModel = null;$el.previousElementSibling.focus()">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <label for="search_model"
                        class="absolute text-sm text-slate-600 dark:text-slate-300 duration-300 transform scale-75 -translate-y-6 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('Model') }}
                    </label>
                </div>
            </div>

            <ul role="listbox" style="display: none" x-show="open"
                class="overflow-y-auto absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white dark:bg-slate-900 py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black dark:ring-slate-900 ring-opacity-5 focus:outline-none sm:text-sm">

                <template x-for="gpuModel in models" :key="gpuModel.id">
                    <li @click="selectedModel = gpuModel; open = false; search = gpuModel.name" role="option"
                        class="cursor-pointer relative cursor-default select-none py-2 pl-3 pr-9 text-slate-950 dark:text-slate-50 hover:bg-indigo-600 hover:text-white"
                        x-show="search === '' || (gpuModel.gpu_brand.name + ' ' + gpuModel.name + ' ' + gpuModel.gpu_engine_model.gpu_engine_brand.name + ' ' + gpuModel.gpu_engine_model.name).toLowerCase().indexOf(search.toLowerCase()) !== -1">
                        <div class="flex items-center">
                            <span class="ml-3 block truncate"
                                x-text="gpuModel.gpu_brand.name + ' ' + gpuModel.name + ' | ' + gpuModel.gpu_engine_model.gpu_engine_brand.name + ' ' + gpuModel.gpu_engine_model.name + ' | ' + gpuModel.max_power + '{{ __('kW') }}'"></span>
                        </div>

                        <span x-show="selectedModel && selectedModel.id == gpuModel.id"
                            class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                class="text-indigo-500 hover:text-white" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                            </svg>
                        </span>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    <x-input-error :messages="$errors->get('model')" />
</div>
