<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_containers" value="{{ json_encode($ad->props) }}" />

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" min="1" autocomplete="capacity"
            :value="$ad->props['Capacity']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Capacity'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('capacity')" />
    </div>

    <div>
        <x-input-label for="heating_area" :value="__('Heating area (m²)')" />
        <x-text-input id="heating_area" name="heating_area" type="number" autocomplete="heating_area"
            :value="$ad->props['Heating area (m²)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Heating area (m²)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('heating_area')" />
    </div>

    <div>
        <x-input-label for="length" :value="__('Length (cm)')" />
        <x-text-input id="length" name="length" type="number" autocomplete="length" :value="$ad->props['Length (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Length (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-input-label for="width" :value="__('Width (cm)')" />
        <x-text-input id="width" name="width" type="number" autocomplete="width" :value="$ad->props['Width (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Width (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-input-label for="height" :value="__('Height (cm)')" />
        <x-text-input id="height" name="height" type="number" autocomplete="height" :value="$ad->props['Height (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Height (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('height')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-950 dark:text-gray-200 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm shadow-logo-color"
            required maxlength="{{ $descriptionMaxLength }}">{{ $ad->description }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
