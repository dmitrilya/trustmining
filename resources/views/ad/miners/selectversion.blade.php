<div x-data="{
    models: {{ $models }},
    withAllVersions: {{ isset($withAllVersions) ? 'true' : 'false' }},
    selectedModel: {{ isset($selectedModel) ? $selectedModel : 'null' }},
    selectedVersion: {{ isset($selectedVersion) ? $selectedVersion->id : 'null' }},
    search: '{{ isset($selectedModel) ? $selectedModel->name : '' }}',
    get currentModel() {
        return this.models.find(m => m.id == this.selectedModel.id);
    },
    get currentVersion() {
        return this.currentModel?.asic_versions.find(v => v.id == this.selectedVersion) ?? null;
    },
}">
    <input class="block h-0 p-0 border-0" type="text" :value="search.toLowerCase().replace(' ', '_')" name="model"
        @if (isset($required)) required @endif aria-label="{{ __('Model') }}">
    <input class="block h-0 p-0 border-0" type="text" :value="selectedVersion" name="asic_version_id"
        @if (isset($required)) required @endif aria-label="{{ __('Version') }}">

    <div class="relative mt-1" x-data="{ open: false }" @click.away="open = false">
        <div class="relative z-0 w-full" @click="open = true">
            <div class="flex items-center justify-between group border-b-2 border-slate-300 dark:border-slate-700">
                <input type="text" autocomplete="off" :value="search" id="search_model"
                    @input="search = $el.value;selectedModel = null;selectedVersion = null"
                    class="block py-2.5 px-0 w-full text-sm text-slate-950 bg-transparent border-0 appearance-none dark:text-white group-focus:outline-none focus:ring-0 peer" />

                <button type="button" aria-label="Clear"
                    class="ml-4 flex h-4 w-4 items-center justify-center rounded-md text-slate-500 dark:text-slate-400"
                    @click="search = '';selectedModel = null;selectedVersion = null">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <label for="search_model"
                    class="absolute text-sm text-slate-600 dark:text-slate-300 duration-300 transform scale-75 -translate-y-6 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Model') }}
                </label>
            </div>
        </div>

        <ul role="listbox" x-show="open"
            class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white dark:bg-slate-900 py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black dark:ring-slate-900 ring-opacity-5 focus:outline-none sm:text-sm">

            <template x-for="asicModel in models" :key="asicModel.id">
                <li @click="selectedModel = asicModel; open = false; search = asicModel.name"
                    class="relative cursor-default select-none py-2 pl-3 pr-9 text-slate-950 dark:text-slate-50 hover:bg-indigo-600 hover:text-white"
                    role="option"
                    x-show="search === '' || asicModel.name.toLowerCase().indexOf(search.toLowerCase()) !== -1">
                    <div class="flex items-center">
                        <span class="ml-3 block truncate" x-text="asicModel.name"></span>
                    </div>

                    <span x-show="selectedModel && selectedModel.id == asicModel.id"
                        class="absolute inset-y-0 right-0 flex items-center pr-4">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                            class="text-indigo-600 hover:text-white" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                        </svg>
                    </span>
                </li>
            </template>
        </ul>
    </div>

    <template x-if="selectedModel">
        <div class="mt-4">
            <p class="block text-sm text-slate-800 dark:text-slate-300">{{ __('Version') }}</p>

            <div class="relative mt-1" x-data="{ show: false }" @click.away="show = false">
                <button type="button" @click="show = !show"
                    class="h-9 w-full cursor-pointer rounded-md text-slate-950 dark:text-slate-50 bg-white dark:bg-slate-900 py-1.5 pl-3 pr-10 text-left shadow-sm ring-1 ring-slate-300 dark:ring-slate-700">
                    <span class="block truncate" x-text="currentVersion?.hashrate ?? '{{ isset($withAllVersions) ? __('All') : '' }}'"></span>

                    <span class="absolute inset-y-0 right-0 flex items-center pr-2">
                        <svg class="h-5 w-5 text-slate-500 dark:text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                        </svg>
                    </span>
                </button>

                <ul class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white dark:bg-slate-900 py-1 text-base shadow-lg"
                    x-show="show">

                    @if (isset($withAllVersions))
                        <li @click="selectedVersion = null; show = false;" role="option"
                            class="relative cursor-default select-none py-2 pl-3 pr-9 text-slate-950 dark:text-slate-50 hover:bg-indigo-600 hover:text-white">
                            <span class="block truncate">{{ __('All') }}</span>

                            <span x-show="selectedVersion == null"
                                class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                    class="text-indigo-600 hover:text-white" aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                                </svg>
                            </span>
                        </li>
                    @endif

                    <template x-for="asicVersion in selectedModel.asic_versions" :key="asicVersion.id">
                        <li @click="selectedVersion = asicVersion.id; show = false;"
                            class="cursor-default relative select-none py-2 pl-3 pr-9 text-slate-950 dark:text-slate-50 hover:bg-indigo-600 hover:text-white">
                            <span class="block truncate" x-text="asicVersion.hashrate"></span>

                            <span x-show="selectedVersion == asicVersion.id"
                                class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                                </svg>
                            </span>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </template>

    <x-input-error :messages="$errors->get('asic_version_id')" />
</div>
