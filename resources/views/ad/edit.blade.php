<x-app-layout title="Редактировать объявление о продаже оборудования для майнинга" noindex="true">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    
    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Editing an advertisement') }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 py-4 sm:p-6 lg:p-8">
        <div class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
            <form method="post" action="{{ route('ad.update', ['ad' => $ad->id]) }}" class="mt-6 space-y-6"
                enctype=multipart/form-data>
                @csrf
                @method('PUT')

                <x-inputs.select :label="__('Office')" name="office_id" :key="$ad->office_id" :items="$offices
                    ->map(fn($office) => ['key' => $office->id, 'value' => $office->address])
                    ->keyBy('key')" />

                <div>
                    <x-inputs.input-label for="preview" :value="__('Change preview')" />
                    <x-inputs.file-input id="preview" name="preview" class="mt-1 block w-full"
                        accept=".png,.jpg,.jpeg,.webp" label="max. 2MB" />
                    <x-inputs.input-error :messages="$errors->get('preview')" />
                </div>

                @include('ad.' . $ad->adCategory->name . '.edit')

                <div>
                    <div class="flex items-center">
                        <div class="mr-2 xs:mr-3 w-full">
                            <x-inputs.input-label for="price" :value="__('Price')" />
                            <x-inputs.text-input id="price" name="price" type="number" required autocomplete="price"
                                :value="$ad->price" />
                            <x-inputs.input-error :messages="$errors->get('price')" />
                        </div>

                        <x-inputs.select :label="__('Currency')" name="coin_id" :key="$ad->coin_id" :items="$coins
                            ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation])
                            ->keyBy('key')"
                            :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                    </div>

                    <div class="mt-0.5 xs:mt-1 text-xxs xs:text-xs text-slate-500">
                        {{ __('Enter 0 to display "Price on request"') }}
                    </div>
                </div>

                <x-inputs.checkbox name="with_vat" :checked="$ad->with_vat" value="with_vat">
                    {{ __('Price including VAT') }}
                </x-inputs.checkbox>

                <div class="flex justify-end">
                    <x-buttons.danger-button x-data="" type="button"
                        @click.prevent="$dispatch('open-modal', 'confirm-ad-deletion')">{{ __('Delete an advertisement') }}</x-buttons.danger-button>

                    <x-buttons.primary-button class="ml-3">{{ __('Save') }}</x-buttons.primary-button>
                </div>
            </form>

            <x-modal name="confirm-ad-deletion">
                <form method="post" action="{{ route('ad.destroy', ['ad' => $ad->id]) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg text-slate-800 dark:text-slate-200">
                        {{ __('Are you sure you want to delete this ad?') }}
                    </h2>

                    <div class="mt-8 flex justify-center">
                        <x-buttons.secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-buttons.secondary-button>

                        <x-buttons.danger-button class="ml-3">
                            {{ __('Confirm') }}
                        </x-buttons.danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>
</x-app-layout>
