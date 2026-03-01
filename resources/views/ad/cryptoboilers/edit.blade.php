<div class="space-y-6" x-data="{ description: `{{ old('description') }}` }" x-init="const Delta = Quill.import('delta');
const Link = Quill.import('formats/link');
class CustomLink extends Link {
    static create(value) {
        const node = super.create(value);
        node.classList.add('inline');
        return node;
    }
}

Quill.register(CustomLink, true);

quill = new Quill('#editor', {
    modules: {
        toolbar: {
            container: [
                ['bold', { 'list': 'bullet' }],
            ]
        }
    },
    placeholder: '{{ __('Description') }}...',
    theme: 'snow'
});

quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
    delta.ops.forEach(op => {
        if (op.attributes?.color) delete op.attributes.color;
        if (op.attributes?.background) delete op.attributes.background;
    });

    return delta;
});

quill.root.innerHTML = `{{ $ad->description }}`;

quill.on('text-change', () => description = quill.root.innerHTML);">
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
        <x-text-input id="heating_area" name="heating_area" type="number" autocomplete="heating_area" :value="$ad->props['Heating area (m²)']"
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

    <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-xl">
        <div id="editor"
            class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-4">
        </div>

        <input type="hidden" class="hidden" name="description" :value="description" required>
    </div>
    <x-input-error :messages="$errors->get('description')" />
</div>
