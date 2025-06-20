<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Creating an advertisement') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('ad.store') }}" class="mt-6 space-y-6" enctype=multipart/form-data>
                @csrf

                <input type="hidden" name="ad_category_id" value="1" required>

                @include('ad.components.selectversion')

                <div class="mt-6" x-data="{ open: false, offices: {{ $offices }}, officeId: {{ $offices->first()->id }} }">
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
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
                        accept=".png,.jpg,.jpeg"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                <div class="mt-6" x-data="{ inStock: true }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="inStock" class="sr-only peer" name="in_stock"
                            @change="inStock = ! inStock">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                        </div>
                        <span
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('In stock') }}</span>
                    </label>

                    <div :class="{ 'block': !inStock, 'hidden': inStock }" class="mt-4">
                        <x-input-label for="waiting" :value="__('Waiting (days)')" />
                        <x-text-input id="waiting" name="waiting" type="number" min="1" max="120"
                            autocomplete="waiting" />
                        <x-input-error :messages="$errors->get('waiting')" />
                    </div>
                </div>

                <div class="mt-4" x-data="{ anew: true }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="anew" class="sr-only peer" name="new"
                            @change="anew = ! anew;$refs.images.value=null">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                        </div>
                        <span
                            class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('New') }}</span>
                    </label>

                    <div :class="{ 'block': !anew, 'hidden': anew }">
                        <div class="mt-4">
                            <x-input-label for="warranty" :value="__('Warranty (months)')" />
                            <x-text-input id="warranty" name="warranty" type="number" min="1" max="12"
                                autocomplete="warranty" />
                            <x-input-error :messages="$errors->get('warranty')" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="images" :value="__('Photo')" />
                            <x-file-input id="images" name="images[]" class="mt-1 block w-full" multiple
                                autocomplete="images" accept=".png,.jpg,.jpeg" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                                or JPEG (max. 1MB, 3 items)</p>
                            <x-input-error :messages="$errors->get('images')" />
                            @foreach ($errors->get('images.*') as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="price" :value="__('Price rub')" />
                    <x-text-input id="price" name="price" type="number" required autocomplete="price" />
                    <x-input-error :messages="$errors->get('price')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
