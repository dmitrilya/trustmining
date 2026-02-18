<x-app-layout title="Обновление цен" noindex="true">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Price update') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div class="bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow-sm shadow-logo-color rounded-lg p-2 sm:p-4 md:p-6"
            x-data="{ search: '', changings: [] }">
            <div class="flex justify-between items-center my-6">
                <div class="relative z-0">
                    <input type="text" id="asic-model_search-name" placeholder=" " @input="search = $el.value"
                        autocomplete="off" :value="search"
                        class="py-2.5 px-0 w-full max-w-56 text-sm text-gray-800 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-200 dark:border-zinc-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                    <label for="asic-model_search-name"
                        class="flex items-center absolute text-sm text-gray-600 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                        <svg class="w-3 h-3 mr-2" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                        {{ __('Model') }}
                    </label>
                </div>

                <x-primary-button
                    @click="axios.post('{{ route('ad.update.mass') }}', {changings: changings}).then(r => pushToastAlert(r.data.message, r.data.success ? 'success' : 'error'))">
                    {{ __('Save') }}
                </x-primary-button>
            </div>

            <div class="space-y-1 sm:space-y-2 lg:space-y-3 divide-y divide-gray-400 dark:divide-gray-700">
                @foreach ($ads as $ad)
                    <div x-show="search === '' || '{{ $ad->asicVersion->asicModel->name . ' ' . $ad->asicVersion->hashrate . $ad->asicVersion->measurement }}'.toLowerCase().indexOf(search.toLowerCase()) !== -1"
                        class="grid grid-cols-6 xs:grid-cols-7 xl:grid-cols-8 gap-1 xs:gap-2 sm:gap-3 items-center pt-1 sm:pt-2 ad"
                        data-id="{{ $ad->id }}">
                        <div class="text-gray-600 dark:text-gray-400 text-xxs sm:text-sm col-span-1">
                            {{ $ad->office->city }}
                        </div>
                        <div class="text-gray-600 dark:text-gray-400 text-xxs sm:text-sm col-span-2">
                            {{ $ad->asicVersion->asicModel->name }}
                            {{ $ad->asicVersion->hashrate }}{{ $ad->asicVersion->measurement }}
                        </div>
                        <div class="hidden xs:block text-gray-600 dark:text-gray-400 text-xxs sm:text-sm col-span-1">
                            @if (isset($ad->props['Condition']))
                                <p>{{ __($ad->props['Condition']) }}</p>
                            @endif
                            @if (isset($ad->props['Availability']))
                                <p>{{ __($ad->props['Availability']) }}</p>
                            @endif
                        </div>
                        <div class="hidden xl:block text-gray-600 dark:text-gray-400 text-xxs sm:text-sm col-span-1">
                            @if (isset($ad->props['Waiting (days)']))
                                <p>{{ __('Waiting') . ' ' . __($ad->props['Waiting (days)']) }}</p>
                            @endif
                            @if (isset($ad->props['Warranty (months)']))
                                <p>{{ __('Warranty') . ' ' . __($ad->props['Warranty (months)']) }}</p>
                            @endif
                        </div>
                        <div class="col-span-2">
                            <div class="flex items-center">
                                <x-text-input
                                    class="w-full mr-1 sm:mr-2 text-xxs sm:text-sm !mt-0 rounded-sm sm:rounded-md !px-2"
                                    id="price" name="price" type="number" required value="{{ $ad->price }}"
                                    autocomplete="price"
                                    @change="let id = $el.closest('.ad').getAttribute('data-id');
                                let ad = changings.find(el => el.id == id);
                                if (!ad) changings.push({ id: id, price: $el.value });
                                else ad.price = $el.value;" />

                                <x-checkbox name="with_vat" :checked="$ad->with_vat" value="with_vat" sm="true"
                                    handleChange="(checked => {
                                        console.log(checked);
                                        let id = $el.closest('.ad').getAttribute('data-id');
                                        let ad = changings.find(el => el.id == id);
                                        if (!ad) changings.push({ id: id, with_vat: checked });
                                        else ad.with_vat = checked;
                                    })">
                                    {{ __('VAT') }}
                                </x-checkbox>
                            </div>
                        </div>
                        <div>
                            <x-select name="coin_id" size="sm" :key="$ad->coin_id"
                                handleChange="(coinId => {
                                    let id = $el.closest('.ad').getAttribute('data-id');
                                    let ad = changings.find(el => el.id == id);
                                    if (!ad) changings.push({ id: id, coin_id: coinId });
                                    else ad.coin_id = coinId;
                                })"
                                :items="$coins
                                    ->map(fn($coin) => ['key' => $coin->id, 'value' => $coin->abbreviation])
                                    ->keyBy('key')" :icon="['type' => 'value', 'path' => '/storage/coins/']" />
                        </div>
                    </div>
                @endforeach
            </div>
            <x-primary-button class="block ml-auto mt-6"
                @click="axios.post('{{ route('ad.update.mass') }}', {changings: changings}).then(r => pushToastAlert(r.data.message, r.data.success ? 'success' : 'error'))">
                {{ __('Save') }}
            </x-primary-button>
        </div>
    </div>
</x-app-layout>
