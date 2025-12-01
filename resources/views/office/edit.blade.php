<x-app-layout title="Редактировать офис, точку продаж">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editing an office') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow rounded-lg">
            <form method="post" action="{{ route('office.update', ['office' => $office->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="office-images" :value="__('Photo')" />
                    <x-file-input id="office-images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                        accept=".png,.jpg,.jpeg" multiple
                        @change="if ($el.files.length > 5) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 5]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 5 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <x-peculiarities :ps="$office->peculiarities" model="office" :isForm="true"></x-peculiarities>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="$office->video" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <div class="relative z-0 w-full group">
                    <input type="text" id="address" readonly disabled value="{{ $office->address }}"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-zinc-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                    <label for="address"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        {{ __('Address') }}
                    </label>
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
