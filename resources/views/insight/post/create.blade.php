<x-insight-layout title="Написание поста | TM Insight"
    description="Создайте свою статью и обзор на сайте TrustMining | TM Insight" :header="__('Creation post')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div x-data="{ content: `{{ old('content') }}` }" x-init="const Delta = Quill.import('delta');
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
                    ['bold', 'italic', 'underline'],
                    ['link'],
                ]
            },
            keyboard: {
                bindings: {
                    'list autofill': null
                }
            }
        },
        placeholder: '{{ __('Text of your post') }}',
        theme: 'snow'
    });
    
    quill.on('text-change', () => content = quill.root.innerHTML);">
        <div
            class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
            <form action="{{ route('insight.post.store', ['channel' => $channel->slug]) }}" method="POST"
                class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ errors: [] }"
                @submit.prevent="if (Object.keys(errors).length > 0) {
                    pushToastAlert(Object.values(errors)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
                } else $el.submit();">
                @csrf

                <div>
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                        required />
                    <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                        or JPEG (max. 5MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                    ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                    ->keyBy('key')" />

                <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-xl mt-2 -mx-2 sm:-mx-4">
                    <div id="editor"
                        class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-4">
                    </div>

                    <input type="hidden" class="hidden" name="content" :value="content" required>
                </div>
                <x-input-error :messages="$errors->get('content')" />

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-insight-layout>
