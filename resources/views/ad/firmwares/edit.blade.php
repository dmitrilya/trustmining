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
    <input type="hidden" name="props" x-ref="props_firmwares" value="{{ json_encode($ad->props) }}">

    <div class="relative z-0 w-full group">
        <input type="text" id="asic_model" disabled value="{{ $ad->asicVersion->asicModel->name }}"
            class="block py-2.5 px-0 w-full text-sm text-slate-800 bg-transparent border-0 border-b-2 border-slate-300 appearance-none dark:text-slate-200 dark:border-slate-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
        <label for="asic_model"
            class="absolute text-sm text-slate-600 dark:text-slate-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-indigo-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
            {{ __('Model') }}
        </label>
    </div>

    <div>
        <x-inputs.input-label for="asic_version" :value="__('Version')" />
        <x-inputs.text-input id="asic_version" disabled :value="$ad->asicVersion->hashrate" />
    </div>

    @include('ad.firmwares.modes', ['modes' => collect($ad->props['Modes'])])

    <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl">
        <div id="editor"
            class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200 focus:outline-0 p-4">
        </div>

        <input type="hidden" class="hidden" name="description" :value="description" required>
    </div>
    <x-inputs.input-error :messages="$errors->get('description')" />
</div>
