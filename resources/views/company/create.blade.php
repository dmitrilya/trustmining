<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Company') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('company.store') }}" class="mt-6 space-y-6" enctype=multipart/form-data>
                @csrf

                @if (!Auth::user()->passport)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('Attach 3 scans or photos of your passport. 2-3 and 4-5 pages, also a selfie with a passport. Make sure the images are high quality and all characters are legible. After passing moderation, many seller functions will become available to you.') }}
                    </p>

                    <div>
                        <x-input-label for="passport-images" :value="__('Photo')" />
                        <x-file-input id="passport-images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                            accept=".png,.jpg,.jpeg" multiple required
                            @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="images_help">PNG, JPG
                            or JPEG (max. 2MB, 3 items)</p>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        @foreach ($errors->get('images.*') as $error)
                            <x-input-error :messages="$error" class="mt-2" />
                        @endforeach
                    </div>
                @endif

                <div>
                    <x-input-label for="inn" :value="__('Company INN')" />
                    <x-text-input id="inn" name="inn" class="mt-1 block w-full" required autocomplete="inn" />
                    <x-input-error :messages="$errors->get('inn')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="documents" :value="__('Documents')" />
                    <x-file-input id="documents" name="documents[]" class="mt-1 block w-full" multiple
                        autocomplete="documents" accept=".pdf" required
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="documents_help">PDF (max. 1MB, 3 items)
                    </p>
                    <x-input-error :messages="$errors->get('documents')" class="mt-2" />
                    @foreach ($errors->get('documents.*') as $error)
                        <x-input-error :messages="$error" class="mt-2" />
                    @endforeach
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
