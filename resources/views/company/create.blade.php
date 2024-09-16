<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" id="ad-store" action="{{ route('hosting.store') }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf

                @if (Auth::user()->passport)
                    <div>
                        <x-input-label for="passport-images" :value="__('Photo')" />
                        <x-file-input id="passport-images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                            accept=".png,.jpg,.jpeg" multiple required
                            @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="images_help">PNG, JPG
                            or JPEG (max. 2MB, 3 items)</p>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                    </div>
                @endif

                <div>
                    <x-input-label for="company" :value="__('Tariff')" />
                    <x-text-input id="company" name="company" class="mt-1 block w-full" required autocomplete="company"/>
                    <x-input-error :messages="$errors->get('company')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="documents" :value="__('Documents')" />
                    <x-file-input id="documents" name="documents[]" class="mt-1 block w-full" multiple
                        autocomplete="documents" accept=".pdf" required
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="documents_help">PDF (max. 1MB, 3 items)
                    </p>
                    <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
