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
    <input type="hidden" name="props" x-ref="props_legals" value="{{ json_encode($ad->props) }}" />

    <div>
        <x-inputs.input-label for="area_of_activity" :value="__('Service')" />
        <x-inputs.text-input id="area_of_activity" name="area_of_activity" type="text" autocomplete="area_of_activity"
            :value="$ad->props['Service']" required
            @change="let props = JSON.parse($refs.props_legals.value);props['Service'] = $el.value;$refs.props_legals.value = JSON.stringify(props)" />
        <x-inputs.input-error :messages="$errors->get('area_of_activity')" />
    </div>

    <x-inputs.editor name="description" />
    <x-inputs.input-error :messages="$errors->get('description')" />
</div>
