<div class="space-y-6">
    <input type="hidden" name="props" x-ref="props_containers" value="{{ json_encode($ad->props) }}" />

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" min="30" autocomplete="capacity"
            :value="$ad->props['Capacity']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Capacity'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('capacity')" />
    </div>

    <div>
        <x-input-label for="power" :value="__('Power') . ' (' . __('kW') . ')'" />
        <x-text-input id="power" name="power" type="number" min="90" autocomplete="power"
            :value="$ad->props['Power']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Power'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('power')" />
    </div>

    <div>
        <x-input-label for="length" :value="__('Length') . ' ' . __('cm') . '.'" />
        <x-text-input id="length" name="length" type="text" autocomplete="length" :value="$ad->props['Length']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Length'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-input-label for="width" :value="__('Width') . ' ' . __('cm') . '.'" />
        <x-text-input id="width" name="width" type="text" autocomplete="width" :value="$ad->props['Width']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Width'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-input-label for="height" :value="__('Height') . ' ' . __('cm') . '.'" />
        <x-text-input id="height" name="height" type="text" autocomplete="height" :value="$ad->props['Height']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Height'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('height')" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Description')" />
        <textarea id="description" rows="16" name="description"
            class="mt-1 px-3 py-2 resize-none w-full px-0 text-sm text-gray-900 dark:text-gray-300 bg-gray-100 dark:bg-zinc-950 rounded-md border-gray-300 dark:border-zinc-700 focus:border-indigo-500 dark:focus:border-indigo-500 focus:ring-indigo-500 shadow-sm dark:shadow-zinc-800"
            required maxlength="{{ ($user = Auth::user()) && $user->tariff ? $user->tariff->max_description : 500 }}">{{ $ad->description }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
