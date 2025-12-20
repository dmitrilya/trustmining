<div class="space-y-6">
    @include('ad.miners.selectversion', ['required' => true])

    <input type="hidden" name="props" x-ref="props_miners" value='{"Condition": "New", "Availability": "In stock"}'>

    <div x-data="{ inStock: true }">
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" :value="inStock" class="sr-only peer" name="in_stock"
                @change="inStock = ! inStock;let props = JSON.parse($refs.props_miners.value);props.Availability = inStock ? 'In stock' : 'Preorder';delete props['Waiting (days)'];$refs.props_miners.value = JSON.stringify(props);">
            <div
                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-600">
            </div>
            <span class="ms-3 text-sm text-gray-950 dark:text-gray-200">{{ __('In stock') }}</span>
        </label>

        <div :class="{ 'block': !inStock, 'hidden': inStock }" class="mt-4">
            <x-input-label for="waiting" :value="__('Waiting (days)')" />
            <x-text-input id="waiting" name="waiting" type="number" min="1" max="120"
                autocomplete="waiting"
                @change="let props = JSON.parse($refs.props_miners.value);props['Waiting (days)'] = $el.value;$refs.props_miners.value = JSON.stringify(props);" />
            <x-input-error :messages="$errors->get('waiting')" />
        </div>
    </div>

    <div x-data="{ anew: true }">
        <label class="inline-flex items-center cursor-pointer">
            <input type="checkbox" :value="anew" class="sr-only peer" name="new"
                @change="anew = ! anew;$refs.images.value=null;let props = JSON.parse($refs.props_miners.value);props.Condition = anew ? 'New' : 'Used';delete props['Warranty (months)'];$refs.props_miners.value = JSON.stringify(props);">
            <div
                class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-zinc-700 peer-checked:bg-indigo-600">
            </div>
            <span class="ms-3 text-sm text-gray-950 dark:text-gray-200">{{ __('New') }}</span>
        </label>

        <div :class="{ 'block': !anew, 'hidden': anew }">
            <div class="mt-4">
                <x-input-label for="warranty" :value="__('Warranty (months)')" />
                <x-text-input id="warranty" name="warranty" type="number" min="1" max="12"
                    autocomplete="warranty"
                    @change="let props = JSON.parse($refs.props_miners.value);props['Warranty (months)'] = $el.value;$refs.props_miners.value = JSON.stringify(props);" />
                <x-input-error :messages="$errors->get('warranty')" />
            </div>

            <div class="mt-6">
                <x-input-label for="images" :value="__('Photo')" />
                <x-file-input id="images" name="images[]" x-ref="images" class="mt-1 block w-full" multiple
                    autocomplete="images" accept=".png,.jpg,.jpeg,.webp" />
                <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                    or JPEG (max. 1MB, 3 items)</p>
                <x-input-error :messages="$errors->get('images')" />
                @foreach ($errors->get('images.*') as $error)
                    <x-input-error :messages="$error" />
                @endforeach
            </div>
        </div>
    </div>
</div>
