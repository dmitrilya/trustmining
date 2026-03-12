<x-insight-layout title="Написание поста | TM Insight"
    description="Создайте свою статью и обзор на сайте TrustMining | TM Insight" :header="__('Creation post')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div
        class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
        <form action="{{ route('insight.post.store', ['channel' => $channel->slug]) }}" method="POST"
            class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ validation: [], loading: false, content: `{{ old('content') }}` }" x-init="const Delta = Quill.import('delta');
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
            
            quill.on('text-change', () => {
                content = quill.root.innerHTML;
                if (validation['content']) delete validation['content'];
            });"
            @submit.prevent="if (Object.keys(validation).length > 0) {
                    pushToastAlert(Object.values(validation)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(validation)[0]}']`).focus();
                } else if (!loading) {
                    loading = true;
                    axios.post($el.action, new FormData($el), {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(r => {
                        if (r.data.success) window.location.href = r.data.redirect;
                        else pushToastAlert(r.data.message, 'error');
                    }).catch(err => {
                        loading = false;
                        if (err.response && err.response.status === 422) validation = err.response.data.errors;
                    });
                }">
            @csrf

            <div>
                <x-input-label for="preview" :value="__('Preview')" />
                <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                    required />
                <p class="mt-1 text-sm text-slate-500" id="file_input_help">(max. 5MB), 4/3</p>
                <template x-if="validation.preview">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.preview?.[0]"></p>
                </template>
            </div>

            <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                ->keyBy('key')" />

            <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl mt-2 -mx-2 sm:-mx-4">
                <div id="editor"
                    class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-100 focus:outline-0 p-4">
                </div>

                <input type="hidden" class="hidden" name="content" :value="content" required>
            </div>
            <template x-if="validation.content">
                <p class="text-red-500 text-xs mt-1" x-text="validation.content?.[0]"></p>
            </template>

            <x-primary-button class="block ml-auto" ::disabled="loading"
                ::class="loading ? 'opacity-50 cursor-progress' : ''">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-insight-layout>
