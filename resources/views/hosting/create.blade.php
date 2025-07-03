<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Placement data') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('hosting.store') }}" class="mt-6 space-y-6" enctype=multipart/form-data>
                @csrf

                <div>
                    <x-input-label for="hosting-images" :value="__('Photo')" />
                    <x-file-input id="hosting-images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                        accept=".png,.jpg,.jpeg" multiple required
                        @change="if ($el.files.length > 10) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 10]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 10 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <div class="relative mt-1" x-data="{ open: false, sugs: false }" @click.away="open = false">
                    <div class="relative z-0 w-full group" @click="open = true">
                        <input type="text" id="address" name="address" x-ref="search" placeholder=" "
                            @input.debounce.1000ms="sugs = dadataSuggs($el.value, $refs.suggestionList, open, 'address')"
                            autocomplete="off"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                        <label for="address"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Address of the territory (can be omitted)') }}
                        </label>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                        class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    </ul>
                </div>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="old('video')" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <x-peculiarities model="hosting" :isForm="true"></x-peculiarities>

                <x-editable-list name="conditions">
                    <x-input-label :value="__('Conditions (from n units, from x th, etc.)')" />
                </x-editable-list>

                <x-editable-list name="expenses">
                    <x-input-label :value="__('Additional costs (e.g. delivery to the territory)')" />
                </x-editable-list>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" rows="16" name="description"
                        class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 bg-gray-100 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        required maxlength="1500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div>
                    <x-input-label for="hosting-documents" :value="__('Documents')" />
                    <x-file-input id="hosting-documents" name="documents[]" class="mt-1 block w-full" multiple
                        autocomplete="documents" accept=".doc,.docx" :value="old('documents')"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="documents_help">DOC (max. 1MB, 3 items)
                    </p>
                    <x-input-error :messages="$errors->get('documents')" />
                    @foreach ($errors->get('documents.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="price" :value="__('Tariff')" />
                    <x-text-input id="price" name="price" required autocomplete="price" min="1"
                        max="10" type="number" step="0.01" :value="old('price')" />
                    <x-input-error :messages="$errors->get('price')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
