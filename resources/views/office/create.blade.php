<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Adding an office') }}
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <form method="post" action="{{ route('office.store') }}" class="mt-6 space-y-6" enctype=multipart/form-data>
                @csrf

                <div class="relative mt-1" x-data="{ open: false, sugs: false }" @click.away="open = false">
                    <div class="relative z-0 w-full group" @click="open = true">
                        <input type="text" id="address" name="address" x-ref="search" placeholder=" "
                            @input.debounce.1000ms="sugs = dadataSuggs($el.value, $refs.suggestionList, open, 'address')"
                            autocomplete="off"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                        <label for="address"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Address') }}
                        </label>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                        class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    </ul>
                </div>

                <div>
                    <x-input-label for="office-images" :value="__('Photo')" />
                    <x-file-input id="office-images" name="images[]" class="mt-1 block w-full" :value="old('images')"
                        accept=".png,.jpg,.jpeg" multiple required
                        @change="if ($el.files.length > 5) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 5]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 5 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <x-peculiarities :isForm="true" model="office"></x-peculiarities>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="old('video')" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
