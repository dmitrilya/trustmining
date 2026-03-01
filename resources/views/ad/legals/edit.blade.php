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
        <x-input-label for="area_of_activity" :value="__('Service')" />
        <x-text-input id="area_of_activity" name="area_of_activity" type="text" autocomplete="area_of_activity"
            :value="$ad->props['Service']" required
            @change="let props = JSON.parse($refs.props_legals.value);props['Service'] = $el.value;$refs.props_legals.value = JSON.stringify(props)" />
        <x-input-error :messages="$errors->get('area_of_activity')" />
    </div>

    <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-xl">
        <div id="editor"
            class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-4">
        </div>

        <input type="hidden" class="hidden" name="description" :value="description" required>
    </div>
    <x-input-error :messages="$errors->get('description')" />
</div>
