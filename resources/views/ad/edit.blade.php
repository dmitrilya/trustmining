<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editing an advertisement') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('ad.update', ['ad' => $ad->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf
                @method('PUT')

                <div class="relative z-0 w-full group">
                    <input type="text" id="asic_model" disabled value="{{ $ad->asicVersion->asicModel->name }}"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                    <label for="asic_model"
                        class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('Model') }}
                    </label>
                </div>

                <div>
                    <x-input-label for="asic_version" :value="__('Version')" />
                    <x-text-input id="asic_version" disabled :value="$ad->asicVersion->hashrate" />
                </div>

                <div class="mt-6" x-data="{ open: false, offices: {{ $offices }}, officeId: {{ $ad->office->id }} }">
                    <x-input-label :value="__('Office')" />
                    <input type="hidden" name="office_id" :value="officeId">

                    <div class="relative mt-1">
                        <button type="button" @click="open = ! open"
                            class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 sm:text-sm sm:leading-6">
                            <span class="flex items-center">
                                <span class="ml-3 block truncate"
                                    x-text="offices.filter(office => office.id == officeId)[0].address"></span>
                            </span>
                            <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-2">
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" />
                                </svg>
                            </span>
                        </button>

                        <ul x-show="open" @click.away="open = false" style="display: none"
                            class="absolute z-10 mt-1 max-h-56 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">

                            @foreach ($offices as $office)
                                <li @click="officeId = {{ $office->id }};open = false"
                                    class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 hover:bg-indigo-600 hover:text-white">
                                    <div class="ml-3 block truncate font-normal">{{ $office->address }}</div>

                                    <span x-show="{{ $office->id }} == officeId"
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

                <div class="mt-6">
                    <x-input-label for="preview" :value="__('Change preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
                        accept=".png,.jpg,.jpeg"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB)</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                <div class="mt-6" x-data="{ inStock: {{ $ad->in_stock ? 'true' : 'false' }} }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="inStock" class="sr-only peer" disabled
                            @change="inStock = ! inStock">
                        <div
                            class="relative w-11 h-6 bg-gray-100 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-300">
                        </div>
                        <span
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('In stock') }}</span>
                    </label>

                    <div :class="{ 'block': !inStock, 'hidden': inStock }" class="mt-4">
                        <x-input-label for="waiting" :value="__('Waiting (days)')" />
                        <x-text-input id="waiting" name="waiting" type="number" min="1" max="120"
                            autocomplete="waiting" :value="$ad->waiting" />
                        <x-input-error :messages="$errors->get('waiting')" />
                    </div>
                </div>

                <div class="mt-4" x-data="{ anew: {{ $ad->new ? 'true' : 'false' }} }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="anew" class="sr-only peer" disabled
                            @change="anew = ! anew">
                        <div
                            class="relative w-11 h-6 bg-gray-100 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-300">
                        </div>
                        <span
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('New') }}</span>
                    </label>

                    <div :class="{ 'block': !anew, 'hidden': anew }">
                        <div class="mt-4">
                            <x-input-label for="warranty" :value="__('Warranty (months)')" />
                            <x-text-input id="warranty" name="warranty" type="number" min="1" max="12"
                                autocomplete="warranty" :value="$ad->warranty" />
                            <x-input-error :messages="$errors->get('warranty')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="images" :value="__('Change photo')" />
                            <x-file-input id="images" name="images[]" class="mt-1 block w-full" multiple
                                autocomplete="images" accept=".png,.jpg,.jpeg" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                                or JPEG (max. 2MB, 3 items)</p>
                            <x-input-error :messages="$errors->get('images')" />
                            @foreach ($errors->get('images.*') as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="price" :value="__('Price rub')" />
                    <x-text-input id="price" name="price" type="number" required autocomplete="price"
                        :value="$ad->price" />
                    <x-input-error :messages="$errors->get('price')" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-danger-button x-data="" type="button"
                        @click.prevent="$dispatch('open-modal', 'confirm-ad-deletion')">{{ __('Delete an advertisement') }}</x-danger-button>

                    <x-primary-button class="ml-3">{{ __('Save') }}</x-primary-button>
                </div>
            </form>

            <x-modal name="confirm-ad-deletion">
                <form method="post" action="{{ route('ad.destroy', ['ad' => $ad->id]) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to delete this ad?') }}
                    </h2>

                    <div class="mt-8 flex justify-center">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            {{ __('Confirm') }}
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
