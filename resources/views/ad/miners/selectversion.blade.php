<div x-data="{
    models: {{ $models }},
    withAllVersions: {{ isset($withAllVersions) ? 'true' : 'false' }},
    selectedModel: {{ isset($selectedModel) ? $selectedModel->id : 'null' }},
    selectedVersion: {{ isset($selectedVersion) ? $selectedVersion->id : 'null' }},
    search: '{{ isset($selectedModel) ? $selectedModel->name : '' }}',
    openDropdown: null
}">
    <input class="block h-0 p-0 border-0" type="text" :value="search.toLowerCase().replace(' ', '_')" name="model"
        @if (isset($required)) required @endif aria-label="{{ __('Model') }}">
    <input class="block h-0 p-0 border-0" type="text" :value="selectedVersion" name="asic_version_id"
        @if (isset($required)) required @endif aria-label="{{ __('Version') }}">

    <div>
        <div class="relative mt-1" x-data="{ open: false }" @click.away="open = false">
            <div class="relative z-0 w-full" @click="open = true">
                <div class="flex items-center justify-between group border-b-2 border-gray-300 dark:border-zinc-700">
                    <input type="text" autocomplete="off" :value="search" id="search_model"
                        @input="search = $el.value;selectedModel = null;selectedVersion = null; if (typeof version !== 'undefined') version = null"
                        class="block py-2.5 px-0 w-full text-sm text-gray-950 bg-transparent border-0 appearance-none dark:text-white group-focus:outline-none focus:ring-0 peer" />

                    <button type="button" aria-label="Clear"
                        class="ml-4 flex h-4 w-4 items-center justify-center rounded-md text-gray-500 dark:text-gray-400"
                        @click="search = '';selectedModel = null;selectedVersion = null; if (typeof version !== 'undefined') version = null">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <label for="search_model"
                        class="absolute text-sm text-gray-600 dark:text-gray-300 duration-300 transform scale-75 -translate-y-6 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('Model') }}
                    </label>
                </div>
            </div>

            <ul role="listbox" style="display: none" x-show="open"
                class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white dark:bg-zinc-900 py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black dark:ring-zinc-900 ring-opacity-5 focus:outline-none sm:text-sm">

                @foreach ($models as $asicModel)
                    <li @click="selectedModel = {{ $asicModel->id }}; open = false; search = '{{ $asicModel->name }}'"
                        class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-950 dark:text-gray-50 hover:bg-indigo-600 hover:text-white"
                        role="option"
                        x-show="search === '' || '{{ $asicModel->name }}'.toLowerCase().indexOf(search.toLowerCase()) !== -1">
                        <div class="flex items-center">
                            <span class="ml-3 block truncate">{{ $asicModel->name }}</span>
                        </div>

                        <span
                            x-show="selectedModel == {{ $asicModel->id }}"
                            class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                class="text-indigo-600 hover:text-white" aria-hidden="true">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                            </svg>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @foreach ($models as $asicModel)
        <div x-show="selectedModel == {{ $asicModel->id }}" class="mt-6" style="display: none">
            <p class="block text-sm text-gray-800 dark:text-gray-300">{{ __('Version') }}</p>

            <div class="relative mt-1" @click.away="openDropdown = null">
                <button type="button"
                    @click="openDropdown = openDropdown === {{ $asicModel->id }} ? null : {{ $asicModel->id }}"
                    class="h-9 relative w-full cursor-pointer rounded-md bg-white dark:bg-zinc-900 py-1.5 pl-3 pr-10 text-left text-gray-950 dark:text-gray-50 shadow-sm shadow-logo-color ring-1 ring-inset ring-gray-300 dark:ring-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <span class="flex items-center">
                        <span class="ml-3 block truncate"
                            x-text="selectedVersion == null ? withAllVersions ? '{{ __('All') }}' : '' : models.find(function(model) {return model.id == selectedModel}).asic_versions.find(function(version) {return version.id == selectedVersion}).hashrate"></span>
                    </span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                        <svg class="h-5 w-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                        </svg>
                    </span>
                </button>

                <ul class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white dark:bg-zinc-900 py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                    x-show="openDropdown === {{ $asicModel->id }}">

                    @if (isset($withAllVersions))
                        <li @click="selectedVersion = null; openDropdown = null;"
                            role="option"
                            class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-950 dark:text-gray-50 hover:bg-indigo-600 hover:text-white">
                            <span class="ml-3 block truncate">{{ __('All') }}</span>

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

                    @foreach ($asicModel->asicVersions as $asicVersion)
                        <li @click="selectedVersion = {{ $asicVersion->id }}; if (typeof version !== 'undefined') version = {{ $asicVersion }}; openDropdown = null;"
                            role="option"
                            class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-950 dark:text-gray-50 hover:bg-indigo-600 hover:text-white">
                            <span class="ml-3 block truncate">{{ $asicVersion->hashrate }}</span>

                            <span x-show="selectedVersion == {{ $asicVersion->id }}"
                                class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                    class="text-indigo-600 hover:text-white" aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" />
                                </svg>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endforeach

    <x-input-error :messages="$errors->get('asic_version_id')" />
</div>
