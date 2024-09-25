<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Placement data') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
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
                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" class="mt-2" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" class="mt-1 block w-full"
                        :value="old('video')" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" class="mt-2" />
                </div>

                <x-peculiarities model="hosting" :isForm="true"></x-peculiarities>

                <div>
                    <x-input-label for="conditions" :value="__('Important conditions (separated by ;)')" />
                    <x-text-input id="conditions" name="conditions" type="text" class="mt-1 block w-full"
                        :value="old('conditions')" autocomplete="conditions" />
                    <x-input-error :messages="$errors->get('conditions')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="expenses" :value="__('Additional costs (separated by ;)')" />
                    <x-text-input id="expenses" name="expenses" type="text" class="mt-1 block w-full"
                        :value="old('expenses')" autocomplete="expenses" />
                    <x-input-error :messages="$errors->get('expenses')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" rows="16" name="description"
                        class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 bg-gray-100 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        required maxlength="1500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="hosting-documents" :value="__('Documents')" />
                    <x-file-input id="hosting-documents" name="documents[]" class="mt-1 block w-full" multiple
                        autocomplete="documents" accept=".pdf" :value="old('documents')"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="documents_help">PDF (max. 1MB, 3 items)
                    </p>
                    <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                    @foreach ($errors->get('documents.*') as $error)
                        <x-input-error :messages="$error" class="mt-2" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="price" :value="__('Tariff')" />
                    <x-text-input id="price" name="price" class="mt-1 block w-full" required autocomplete="price"
                        min="1" max="10" type="number" step="0.01" :value="old('price')" />
                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
