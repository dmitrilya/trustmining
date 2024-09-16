<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editing an advertisement') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" id="ad-update" action="{{ route('ads.update', ['ad' => $ad->id]) }}" class="mt-6 space-y-6"
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
                    <x-text-input id="asic_version" class="mt-1 block w-full" disabled :value="$ad->asicVersion->hashrate" />
                </div>

                <div class="mt-6">
                    <x-input-label for="preview" :value="__('Change preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
                        accept=".png,.jpg,.jpeg"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB)</p>
                    <x-input-error :messages="$errors->get('preview')" class="mt-2" />
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
                        <x-text-input id="waiting" name="waiting" type="number" class="mt-1 block w-full"
                            min="1" max="120" autocomplete="waiting" :value="$ad->waiting" />
                        <x-input-error :messages="$errors->get('waiting')" class="mt-2" />
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
                            <x-text-input id="warranty" name="warranty" type="number" class="mt-1 block w-full"
                                min="1" max="12" autocomplete="warranty" :value="$ad->warranty" />
                            <x-input-error :messages="$errors->get('warranty')" class="mt-2" />
                        </div>

                        <div class="mt-6">
                            <x-input-label for="images" :value="__('Change photo')" />
                            <x-file-input id="images" name="images[]" class="mt-1 block w-full" multiple
                                autocomplete="images" accept=".png,.jpg,.jpeg" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG
                                or JPEG (max. 2MB, 3 items)</p>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div>
                    <x-input-label for="price" :value="__('Price rub')" />
                    <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" required
                        autocomplete="price" :value="$ad->price" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-danger-button x-data="" type="button"
                        @click.prevent="$dispatch('open-modal', 'confirm-ad-deletion')">{{ __('Delete an advertisement') }}</x-danger-button>

                    <x-primary-button class="ml-3">{{ __('Save') }}</x-primary-button>
                </div>
            </form>

            <x-modal name="confirm-ad-deletion">
                <form method="post" action="{{ route('ads.destroy', ['ad' => $ad->id]) }}" class="p-6">
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
