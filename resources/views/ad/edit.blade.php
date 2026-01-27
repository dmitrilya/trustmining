<x-app-layout title="Редактировать объявление о продаже оборудования для майнинга">
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Editing an advertisement') }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow rounded-lg">
            <form method="post" action="{{ route('ad.update', ['ad' => $ad->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf
                @method('PUT')

                <x-select :label="__('Office')" name="office_id" :key="$ad->office_id" :items="$offices
                    ->map(fn($office) => ['key' => $office->id, 'value' => $office->address])
                    ->keyBy('key')" />

                <div>
                    <x-input-label for="preview" :value="__('Change preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
                        accept=".png,.jpg,.jpeg,.webp"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB)</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                @php
                    $descriptionMaxLength =
                        ($user = Auth::user()) && $user->tariff ? $user->tariff->max_description : 500;
                @endphp

                @include('ad.' . $ad->adCategory->name . '.edit')

                <div>
                    <div class="flex items-center">
                        <div class="mr-2 xs:mr-3 w-full">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" required autocomplete="price"
                                :value="$ad->price" />
                            <x-input-error :messages="$errors->get('price')" />
                        </div>

                        <x-select :label="__('Currency')" name="coin_id" :key="$ad->coin_id" :items="$coins
                            ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation])
                            ->keyBy('key')"
                            :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                    </div>

                    <div class="mt-0.5 xs:mt-1 text-xxs xs:text-xs text-gray-500">
                        {{ __('Enter 0 to display "Price on request"') }}
                    </div>
                </div>

                <x-checkbox name="with_vat" :checked="$ad->with_vat" value="with_vat">
                    {{ __('Price including VAT') }}
                </x-checkbox>

                <div class="flex justify-end">
                    <x-danger-button x-data="" type="button"
                        @click.prevent="$dispatch('open-modal', 'confirm-ad-deletion')">{{ __('Delete an advertisement') }}</x-danger-button>

                    <x-primary-button class="ml-3">{{ __('Save') }}</x-primary-button>
                </div>
            </form>

            <x-modal name="confirm-ad-deletion">
                <form method="post" action="{{ route('ad.destroy', ['ad' => $ad->id]) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg text-gray-950 dark:text-gray-50">
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
