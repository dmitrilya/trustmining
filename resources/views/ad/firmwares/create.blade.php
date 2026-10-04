<div class="space-y-6" x-data="{ measurement: '', description: `{{ old('description', '') }}` }" x-init="const Delta = Quill.import('delta');
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
    <input type="hidden" name="props" x-ref="props_firmwares" value="{{ old('props') ?? '{"Modes": [], "Fee (%)": 0}' }}">

    @php
        $selectedModel = old('model') ? App\Models\Database\AsicModel::where('slug', old('model'))->first() : null;
        $selectedVersion = $selectedModel && old('asic_version_id') ? App\Models\Database\AsicVersion::find(old('asic_version_id')) : null;
    @endphp

    @include('ad.miners.selectversion', ['required' => true, 'selectedModel' => $selectedModel, 'selectedVersion' => $selectedVersion])
    @include('ad.firmwares.modes', ['modes' => collect(json_decode(old('props'), true)['Modes'] ?? [])])

    <div class="w-full">
        <x-inputs.input-label for="fee" :value="__('Fee (%)')" />
        <x-inputs.text-input id="fee" :value="json_decode(old('props'), true)['Fee (%)'] ?? 0" type="text"
            @input="count = filterDouble($el, 1, 100, 2);$el.value = count"
            @change="let props = JSON.parse($refs.props_firmwares.value);props['Fee (%)'] = $el.value;$refs.props_firmwares.value = JSON.stringify(props);" />
    </div>

    <x-inputs.editor name="description" />
    <x-inputs.input-error :messages="$errors->get('description')" />
</div>
