<div class="space-y-6">
    @include('ad.gpus.selectmodel', ['required' => true])

    <input type="hidden" name="props" x-ref="props_gpus" value='{"Enclosure": "On frame", "Condition": "New", "Availability": "In stock"}'>

    <x-inputs.select :label="__('Enclosure')" name="Enclosure"
        handleChange="(enclosure => {
            let props = JSON.parse($refs.props_gpus.value);
            props['Enclosure'] = enclosure;
            $refs.props_gpus.value = JSON.stringify(props);
        })"
        :items="collect([
            ['key' => 'On frame', 'value' => __('On frame')],
            ['key' => 'In a casing', 'value' => __('In a casing')],
            ['key' => 'In a container', 'value' => __('In a container')],
        ])->keyBy('key')" />

    <div x-data="{ inStock: true }">
        <x-inputs.toggler ::checked="inStock" :big="true" name="in_stock"
            x-on:toggle-checked="() => {
                inStock = ! inStock;
                let props = JSON.parse($refs.props_gpus.value);

                if (inStock) {
                    props.Availability = 'In stock';
                    delete props['Waiting (days)'];
                } else {
                    props.Availability = 'Preorder';
                    props['Waiting (days)'] = 30;
                    $refs.waiting.value = 30;
                }

                $refs.props_gpus.value = JSON.stringify(props);
            }">{{ __('In stock') }}</x-inputs.toggler>

        <div :class="{ 'block': !inStock, 'hidden': inStock }" class="mt-4">
            <x-inputs.input-label for="waiting" :value="__('Waiting (days)')" />
            <x-inputs.text-input id="waiting" name="waiting" type="number" min="1" max="180" autocomplete="waiting" x-ref="waiting"
                @change="let props = JSON.parse($refs.props_gpus.value);props['Waiting (days)'] = $el.value;$refs.props_gpus.value = JSON.stringify(props);" />
            <x-inputs.input-error :messages="$errors->get('waiting')" />
        </div>
    </div>

    <div x-data="{ anew: true }">
        <x-inputs.toggler ::checked="anew" :big="true" name="new"
            x-on:toggle-checked="() => {
                anew = ! anew;
                $dispatch('clear-files', { id: 'images' });
                let props = JSON.parse($refs.props_gpus.value);
                
                if (anew) {
                    props.Condition = 'New';
                    delete props['Warranty (months)'];
                } else {
                    props.Condition = 'Used';
                    props['Warranty (months)'] = 0;
                    $refs.warranty.value = 0;
                }
                    
                $refs.props_gpus.value = JSON.stringify(props);
            }">{{ __('New') }}</x-inputs.toggler>

        <div :class="{ 'block': !anew, 'hidden': anew }">
            <div class="mt-4">
                <x-inputs.input-label for="warranty" :value="__('Warranty (months)')" />
                <x-inputs.text-input id="warranty" name="warranty" type="number" min="0" max="12" autocomplete="warranty" x-ref="warranty"
                    @change="let props = JSON.parse($refs.props_gpus.value);props['Warranty (months)'] = $el.value;$refs.props_gpus.value = JSON.stringify(props);" />
                <x-inputs.input-error :messages="$errors->get('warranty')" />
            </div>

            <div class="mt-6">
                <x-inputs.input-label for="images" :value="__('Photo')" />
                <x-inputs.file-input id="images" name="images[]" class="mt-1 block w-full" multiple accept=".png,.jpg,.jpeg,.webp" max="3"
                    label="max. 1MB, 3 items" />
                <x-inputs.input-error :messages="$errors->get('images')" />
                @foreach ($errors->get('images.*') as $error)
                    <x-inputs.input-error :messages="$error" />
                @endforeach
            </div>
        </div>
    </div>
</div>
