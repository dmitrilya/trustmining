<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_containers"
        value='{"Capacity": 1, "Material": "LP", "Length": 0, "Width": 0, "Height": 0}'>

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" min="1" autocomplete="capacity" value="40"
            @change="let props = JSON.parse($refs.props_containers.value);props['Capacity'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('capacity')" />
    </div>

    <div>
        <x-input-label for="power" :value="__('Power')" />
        <x-text-input id="power" name="power" type="number" min="1" autocomplete="power" value="40"
            @change="let props = JSON.parse($refs.props_containers.value);props['Capacity'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('power')" />
    </div>

    <div>
        <x-input-label for="length" :value="__('Length') . ' ' . __('cm') . '.'" />
        <x-text-input id="length" name="length" type="text" autocomplete="length" value="0"
            @change="let props = JSON.parse($refs.props_containers.value);props['Length'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-input-label for="width" :value="__('Width') . ' ' . __('cm') . '.'" />
        <x-text-input id="width" name="width" type="text" autocomplete="width" value="0"
            @change="let props = JSON.parse($refs.props_containers.value);props['Width'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-input-label for="height" :value="__('Height') . ' ' . __('cm') . '.'" />
        <x-text-input id="height" name="height" type="text" autocomplete="height" value="0"
            @change="let props = JSON.parse($refs.props_containers.value);props['Height'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('height')" />
    </div>
</div>
