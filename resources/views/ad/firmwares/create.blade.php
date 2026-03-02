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
    <input type="hidden" name="props" x-ref="props_firmwares" value='{"For which models": []}'>

    <div x-data="{ allModels: {{ App\Models\Database\AsicModel::pluck('name') }}, models: [], search: '' }">
        <div>
            <x-input-label for="search" :value="__('For which models')" />
            <x-text-input id="search" type="text" ::value="search" placeholder="" autocomplete="off"
                @input="search = $el.value" />
        </div>

        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            <template x-for="model in models" :key="model">
                <div>
                    <div @click="
                        models.splice(models.indexOf(model), 1);
                        allModels.push(model);
                        let props = JSON.parse($refs.props_firmwares.value);
                        props['For which models'] = models;
                        $refs.props_firmwares.value = JSON.stringify(props);
                    "
                        x-text="model"
                        class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">

                    </div>
                    <input type="hidden" name="models[]" :value="model">
                </div>
            </template>
        </div>

        <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
            <template
                x-for="model in allModels.filter(allModel => `${allModel.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).slice(0, 20)"
                :key="model">
                <div @click="
                        models.push(model);
                        allModels.splice(allModels.indexOf(model), 1);
                        let props = JSON.parse($refs.props_firmwares.value);
                        props['For which models'] = models;
                        $refs.props_firmwares.value = JSON.stringify(props);
                    "
                    x-text="model"
                    class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
                </div>
            </template>
            <div x-show="allModels.filter(allModel => `${allModel.toLowerCase()}`.indexOf(search.toLowerCase()) !== -1).length > 20"
                class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
                <span x-text="allModels.filter(allModel => `${allModel}`.indexOf(search) !== -1).length - 20"></span>
                {{ __('models more') }}
            </div>
        </div>
    </div>

    <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl">
        <div id="editor"
            class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-100 focus:outline-0 p-4">
        </div>

        <input type="hidden" class="hidden" name="description" :value="description" required>
    </div>
    <x-input-error :messages="$errors->get('description')" />
</div>
