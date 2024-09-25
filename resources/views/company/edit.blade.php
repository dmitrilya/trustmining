<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $company->name }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('company.update', ['company' => $company->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @method('put')
                @csrf

                <div>
                    <x-input-label for="company" :value="__('Company INN')" />
                    <x-text-input id="company" class="mt-1 block w-full" readonly disabled autocomplete="company"
                        value="{{ $company->card['inn'] }}" />
                </div>

                <div>
                    <x-input-label for="images" :value="__('Photo')" />
                    <x-file-input id="images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                        accept=".png,.jpg,.jpeg" multiple
                        @change="if ($el.files.length > 8) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 8]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 8 items)</p>
                    <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" class="mt-2" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="logo" :value="__('Logo')" />
                    <x-file-input id="logo" name="logo" class="mt-1 block w-full" :value="old('logo')"
                        accept=".png,.jpg,.jpeg" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="logo_help">PNG, JPG
                        or JPEG (max. 500KB, 1x1)</p>
                    <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <textarea id="description" rows="16" name="description"
                        class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 bg-gray-100 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                        required maxlength="1500">{{ $company->description }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" class="mt-1 block w-full"
                        :value="$company->video" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" class="mt-2" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
