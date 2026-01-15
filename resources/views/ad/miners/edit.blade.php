<div class="relative z-0 w-full group">
    <input type="text" id="asic_model" disabled value="{{ $ad->asicVersion->asicModel->name }}"
        class="block py-2.5 px-0 w-full text-sm text-gray-950 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-zinc-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
    <label for="asic_model"
        class="absolute text-sm text-gray-600 dark:text-gray-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
        {{ __('Model') }}
    </label>
</div>

<div>
    <x-input-label for="asic_version" :value="__('Version')" />
    <x-text-input id="asic_version" disabled :value="$ad->asicVersion->hashrate" />
</div>

<input type="hidden" name="props" x-ref="props_miners" value="{{ json_encode($ad->props) }}">

<div x-data="{ inStock: {{ $ad->props['Availability'] == 'In stock' ? 'true' : 'false' }} }">
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" :value="inStock" class="sr-only peer" disabled
            @change="inStock = ! inStock;let props = JSON.parse($refs.props_miners.value);props.Availability = inStock ? 'In stock' : 'Preorder';delete props['Waiting (days)'];$refs.props_miners.value = JSON.stringify(props);">
        <div
            class="relative w-11 h-6 bg-gray-100 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-300">
        </div>
        <span class="ms-3 text-sm text-gray-950 dark:text-gray-200">{{ __('In stock') }}</span>
    </label>

    <div x-show="!inStock" class="mt-4">
        <x-input-label for="waiting" :value="__('Waiting (days)')" />
        <x-text-input id="waiting" name="waiting" type="number" min="1" max="120" autocomplete="waiting"
            :value="isset($ad->props['Waiting (days)']) ? $ad->props['Waiting (days)'] : null"
            @change="let props = JSON.parse($refs.props_miners.value);props['Waiting (days)'] = $el.value;$refs.props_miners.value = JSON.stringify(props);" />
        <x-input-error :messages="$errors->get('waiting')" />
    </div>
</div>

<div x-data="{ anew: {{ $ad->props['Condition'] == 'New' ? 'true' : 'false' }} }">
    <label class="inline-flex items-center cursor-pointer">
        <input type="checkbox" :value="anew" class="sr-only peer" disabled
            @change="anew = ! anew;let props = JSON.parse($refs.props_miners.value);props.Condition = anew ? 'New' : 'Used';delete props['Warranty (months)'];$refs.props_miners.value = JSON.stringify(props);">
        <div
            class="relative w-11 h-6 bg-gray-100 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-300">
        </div>
        <span class="ms-3 text-sm text-gray-950 dark:text-gray-200">{{ __('New') }}</span>
    </label>

    <div x-show="!anew">
        <div class="mt-4">
            <x-input-label for="warranty" :value="__('Warranty (months)')" />
            <x-text-input id="warranty" name="warranty" type="number" min="1" max="12"
                autocomplete="warranty" :value="isset($ad->props['Warranty (months)']) ? $ad->props['Warranty (months)'] : null"
                @change="let props = JSON.parse($refs.props_miners.value);props['Warranty (months)'] = $el.value;$refs.props_miners.value = JSON.stringify(props);" />
            <x-input-error :messages="$errors->get('warranty')" />
        </div>

        <div class="mt-6">
            <x-input-label for="images" :value="__('Change photo')" />
            <x-file-input id="images" name="images[]" class="mt-1 block w-full" multiple autocomplete="images"
                accept=".png,.jpg,.jpeg,.webp" />
            <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                or JPEG (max. 2MB, 3 items)</p>
            <x-input-error :messages="$errors->get('images')" />
            @foreach ($errors->get('images.*') as $error)
                <x-input-error :messages="$error" />
            @endforeach
        </div>
    </div>
</div>
