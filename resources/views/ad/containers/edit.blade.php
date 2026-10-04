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
        <x-inputs.input-label for="capacity" :value="__('Capacity')" />
        <x-inputs.text-input id="capacity" name="capacity" type="number" min="30" autocomplete="capacity"
            :value="$ad->props['Capacity']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Capacity'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('capacity')" />
    </div>

    <div>
        <x-inputs.input-label for="power" :value="__('Power (kW)')" />
        <x-inputs.text-input id="power" name="power" type="number" min="90" autocomplete="power" :value="$ad->props['Power (kW)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Power (kW)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('power')" />
    </div>

    <div>
        <x-inputs.input-label for="length" :value="__('Length (cm)')" />
        <x-inputs.text-input id="length" name="length" type="number" autocomplete="length" :value="$ad->props['Length (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Length (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-inputs.input-label for="width" :value="__('Width (cm)')" />
        <x-inputs.text-input id="width" name="width" type="number" autocomplete="width" :value="$ad->props['Width (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Width (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-inputs.input-label for="height" :value="__('Height (cm)')" />
        <x-inputs.text-input id="height" name="height" type="number" autocomplete="height" :value="$ad->props['Height (cm)']"
            @change="let props = JSON.parse($refs.props_containers.value);props['Height (cm)'] = $el.value;$refs.props_containers.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('height')" />
    </div>

    <x-inputs.editor name="description" />
    <x-inputs.input-error :messages="$errors->get('description')" />
</div>
