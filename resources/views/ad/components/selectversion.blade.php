<div x-data="{ models: {{ $models }}, selectedModel: {{ isset($selectedModel) ? $selectedModel->id : 'null' }}, selectedVersion: {{ isset($selectedVersion) ? $selectedVersion->id : 'null' }} }">
    <input type="hidden" :value="selectedVersion" name="asic_version_id" required>

    <div>
        <div class="relative mt-1" x-data="{ open: false, search: '{{ isset($selectedModel) ? $selectedModel->name : '' }}' }" @click.away="open = false">
            <div class="relative z-0 w-full group" @click="open = true">
                <input type="text" id="asic-model_input" placeholder=" "
                    @input="search = $el.value;selectedModel = null;selectedVersion = null" autocomplete="off"
                    :value="search"
                    class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                <label for="asic-model_input"
                    class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                    {{ __('Model') }}
                </label>
            </div>

            <ul role="listbox" style="display: none" x-show="open"
                class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">

                @foreach ($models as $asicModel)
                    <li @click="selectedModel = {{ $asicModel->id }}; selectedVersion = {{ $asicModel->asicVersions[0]->id }}; open = false; search = '{{ $asicModel->name }}'"
                        class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-indigo-600 hover:text-white"
                        role="option"
                        x-show="search === '' || '{{ $asicModel->name }}'.toLowerCase().indexOf(search.toLowerCase()) !== -1">
                        <div class="flex items-center">
                            <span class="ml-3 block truncate font-normal">{{ $asicModel->name }}</span>
                        </div>

                        <span
                            :class="{
                                'block': selectedModel ==
                                    {{ $asicModel->id }},
                                'hidden': selectedModel !=
                                    {{ $asicModel->id }}
                            }"
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
        <div :class="{
            'block': selectedModel == {{ $asicModel->id }},
            'hidden': selectedModel !=
                {{ $asicModel->id }}
        }"
            class="mt-6">
            <x-input-label :value="__('Version')" />

            <div class="relative mt-1">
                <button type="button" data-dropdown-toggle="{{ 'dropdown-version_' . $asicModel->id }}"
                    id="{{ 'dropdown-version_' . $asicModel->id . '_button' }}"
                    class="relative w-full cursor-pointer rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                    <span class="flex items-center">
                        <span class="ml-3 block truncate"
                            x-text="selectedModel != null ? models.find(function(model) {return model.id == selectedModel}).asic_versions.find(function(version) {return version.id == selectedVersion}).hashrate : ''"></span>
                    </span>
                    <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                        </svg>
                    </span>
                </button>

                <ul class="hidden absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
                    aria-labelledby="{{ 'dropdown-version_' . $asicModel->id . '_button' }}"
                    id="{{ 'dropdown-version_' . $asicModel->id }}">

                    @foreach ($asicModel->asicVersions as $asicVersion)
                        <li @click="selectedVersion = {{ $asicVersion->id }}; new Dropdown($event.target.closest('ul'), $event.target.closest('ul').previousElementSibling).hide()"
                            role="option"
                            class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-indigo-600 hover:text-white">
                            <div class="flex items-center">
                                <span class="ml-3 block truncate font-normal">{{ $asicVersion->hashrate }}</span>
                            </div>

                            <span
                                :class="{
                                    'block': selectedVersion ==
                                        {{ $asicVersion->id }},
                                    'hidden': selectedVersion !=
                                        {{ $asicVersion->id }}
                                }"
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
