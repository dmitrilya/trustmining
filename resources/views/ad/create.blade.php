<x-app-layout title="Создать объявление о продаже оборудования для майнинга">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Creating an advertisement') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow rounded-lg">
            <form method="post" action="{{ route('ad.store') }}" class="mt-6 space-y-6" enctype=multipart/form-data>
                @csrf

                <input type="hidden" name="ad_category_id" value="1" required>

                @include('ad.components.selectversion')

                <x-select :label="__('Office')" name="office_id" :items="$offices
                    ->map(fn($office) => ['key' => $office->id, 'value' => $office->address])
                    ->keyBy('key')" />

                <div>
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview" required
                        accept=".png,.jpg,.jpeg"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                <div x-data="{ inStock: true }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="inStock" class="sr-only peer" name="in_stock"
                            @change="inStock = ! inStock">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-600">
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

                <div x-data="{ anew: true }">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" :value="anew" class="sr-only peer" name="new"
                            @change="anew = ! anew;$refs.images.value=null">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-600">
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
                            <p class="mt-1 text-sm text-gray-500" id="file_input_help">PNG, JPG
                                or JPEG (max. 1MB, 3 items)</p>
                            <x-input-error :messages="$errors->get('images')" />
                            @foreach ($errors->get('images.*') as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="mr-2 xs:mr-3 w-full">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input id="price" name="price" type="number" required autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" />
                    </div>

                    <x-select :label="__('Currency')" name="coin_id" :items="$coins
                        ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation])
                        ->keyBy('key')"
                        :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
