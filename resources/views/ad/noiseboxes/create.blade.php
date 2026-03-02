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

quill.on('text-change', () => description = quill.root.innerHTML);">
    <input type="hidden" name="props" x-ref="props_noiseboxes"
        value='{"Capacity": 1, "Material": "LP", "Length (cm)": 0, "Width (cm)": 0, "Height (cm)": 0}'>

    <div>
        <x-input-label for="capacity" :value="__('Capacity')" />
        <x-text-input id="capacity" name="capacity" type="number" min="1" max="10" autocomplete="capacity" value="1"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Capacity'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('capacity')" />
    </div>

    <x-select :label="__('Material')" name="Material"
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
        <x-input-label for="length" :value="__('Length (cm)')" />
        <x-text-input id="length" name="length" type="number" autocomplete="length" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Length (cm)'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('length')" />
    </div>

    <div>
        <x-input-label for="width" :value="__('Width (cm)')" />
        <x-text-input id="width" name="width" type="number" autocomplete="width" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Width (cm)'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('width')" />
    </div>

    <div>
        <x-input-label for="height" :value="__('Height (cm)')" />
        <x-text-input id="height" name="height" type="number" autocomplete="height" value="0"
            @change="let props = JSON.parse($refs.props_noiseboxes.value);props['Height (cm)'] = $el.value;$refs.props_noiseboxes.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('height')" />
    </div>

    <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl">
        <div id="editor"
            class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-100 focus:outline-0 p-4">
        </div>

        <input type="hidden" class="hidden" name="description" :value="description" required>
    </div>
    <x-input-error :messages="$errors->get('description')" />
</div>
