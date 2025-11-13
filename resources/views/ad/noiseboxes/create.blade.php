<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_noiseboxes"
        value='{"Capacity": 1, "Material": "LP", "Length": 0, "Width": 0, "Height": 0}'>

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" min="1" max="10" autocomplete="capacity" value="1"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Capacity'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('capacity')" />
    </div>

    <x-select :label="__('Material')" name="ad_category"
        handleChange="(material => {
            let props = JSON.parse($refs.props_noiseboxes.value);
            props['Material'] = material;
            $refs.props_noiseboxes.value = JSON.stringify(props);
        })"
        :items="(collect([
            ['key' => 'LP', 'value' => __('LP')],
            ['key' => 'OSB', 'value' => __('OSB')],
            ['key' => 'Metal', 'value' => __('Metal')],
            ['key' => 'Another', 'value' => __('Another')],
        ]))->keyBy('key')" />

    <div>
        <x-input-label for="length" :value="__('Length') . ' ' . __('cm') . '.'" />
        <x-text-input id="length" name="length" type="text" autocomplete="length" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Length'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-input-label for="width" :value="__('Width') . ' ' . __('cm') . '.'" />
        <x-text-input id="width" name="width" type="text" autocomplete="width" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Width'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-input-label for="height" :value="__('Height') . ' ' . __('cm') . '.'" />
        <x-text-input id="height" name="height" type="text" autocomplete="height" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Height'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('height')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 dark:text-gray-300 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:shadow-zinc-800"
            required maxlength="{{ $descriptionMaxLength }}">{{ old('description') }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
