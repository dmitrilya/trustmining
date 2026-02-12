<x-app-layout title="Создать объявление о продаже оборудования для майнинга">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Creating an advertisement') }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 shadow rounded-lg" x-data="{ ad_category_id: 1 }">
            <form method="post" action="{{ route('ad.store') }}" class="space-y-6" enctype=multipart/form-data>
                @csrf

                <x-select :label="__('Ad type')" name="ad_category_id"
                    handleChange="(adCategoryId => ad_category_id = adCategoryId)" :items="App\Models\Ad\AdCategory::all()
                        ->map(fn($adCategory) => ['key' => $adCategory->id, 'value' => __($adCategory->header)])
                        ->keyBy('key')" />

                <x-select :label="__('Office')" name="office_id" :items="$offices
                    ->map(fn($office) => ['key' => $office->id, 'value' => $office->address])
                    ->keyBy('key')" />

                <div>
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
                        required accept=".png,.jpg,.jpeg,.webp"
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                @php
                    $descriptionMaxLength =
                        ($user = Auth::user()) && $user->tariff ? $user->tariff->max_description : 500;
                @endphp

                <template x-if="ad_category_id == 1">
                    @include('ad.miners.create')
                </template>

                <template x-if="ad_category_id == 2">
                    @include('ad.legals.create')
                </template>

                <template x-if="ad_category_id == 3">
                    @include('ad.containers.create')
                </template>

                <template x-if="ad_category_id == 4">
                    @include('ad.noiseboxes.create')
                </template>

                <template x-if="ad_category_id == 5">
                    @include('ad.cryptoboilers.create')
                </template>

                <template x-if="ad_category_id == 6">
                    @include('ad.water_cooling_plates.create')
                </template>

                <template x-if="ad_category_id == 7">
                    @include('ad.firmwares.create')
                </template>

                <template x-if="ad_category_id == 8">
                    @include('ad.monitorings.create')
                </template>

                <template x-if="ad_category_id == 9">
                    @include('ad.accessories.create')
                </template>

                <template x-if="ad_category_id == 10">
                    @include('ad.gpus.create')
                </template>

                <div>
                    <div class="flex items-center">
                        <div class="mr-2 xs:mr-3 w-full">
                            <x-input-label for="price" :value="__('Price')" />
                            <x-text-input id="price" name="price" type="number" required autocomplete="price" />
                            <x-input-error :messages="$errors->get('price')" />
                        </div>

                        <x-select :label="__('Currency')" name="coin_id" key="2" :items="$coins
                            ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation])
                            ->keyBy('key')"
                            :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                    </div>

                    <div class="mt-0.5 xs:mt-1 text-xxs xs:text-xs text-gray-500">
                        {{ __('Enter 0 to display "Price on request"') }}
                    </div>
                </div>

                <x-checkbox name="with_vat" :checked="old('with_vat')" value="with_vat">
                    {{ __('Price including VAT') }}
                </x-checkbox>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
