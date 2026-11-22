<x-insight-layout :title="__('meta.insight.content.post.create.title')" :description="__('meta.insight.content.post.create.description')" :header="__('meta.insight.content.post.create.header')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
        <form action="{{ route('insight.post.store', ['channel' => $channel->slug]) }}" method="POST" class="flex flex-col gap-4" enctype=multipart/form-data
            x-data="{ validation: [], loading: false, content: `{{ old('content') }}` }" x-init="const Delta = Quill.import('delta');
            const Inline = Quill.import('blots/inline');
            
            class TermBlot extends Inline {
                static blotName = 'term';
                static tagName = 'span';
                static className = 'term';
            
                static create(value) {
                    const node = super.create();
                    node.setAttribute('data-term', value);
                    return node;
                }
            
                static formats(node) {
                    return node.getAttribute('data-term');
                }
            
                format(name, value) {
                    if (name === 'term' && value) this.domNode.setAttribute('data-term', value);
                    else super.format(name, value);
                }
            }
            Quill.register(TermBlot);
            
            class RateBlot extends Inline {
                static blotName = 'rate';
                static tagName = 'span';
                static className = 'rate';
            
                static create(value) {
                    const node = super.create();
                    node.setAttribute('data-coin', value);
                    node.style.setProperty('--coin-url', `url('/storage/coins/${value}.webp')`);
                    return node;
                }
            
                static formats(node) {
                    return node.getAttribute('data-coin');
                }
            
                format(name, value) {
                    if (name === 'rate' && value) {
                        this.domNode.setAttribute('data-coin', value);
                        this.domNode.style.setProperty('--coin-url', `url('/storage/coins/${value}.webp')`);
                    } else super.format(name, value);
                }
            }
            Quill.register(RateBlot);
            
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
                            ['term', 'rate'],
                        ],
                        handlers: {
                            term: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                const selectedText = this.quill.getText(range.index, range.length);
            
                                attachCallback = (term) => this.quill.updateContents(
                                    new Delta().retain(range.index).delete(range.length).insert(selectedText, { term: term }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'attach-term_modal' }));
                            },
                            rate: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                attachCallback = (coin) => this.quill.updateContents(
                                    new Delta().retain(range.index).delete(range.length).insert(coin, { rate: coin }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'attach-rate_modal' }));
                            },
                        }
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
            
            const toolbar = quill.getModule('toolbar').container;
            
            toolbar.querySelector('.ql-term').innerHTML = `
                            <svg viewBox='0 0 24 24' width='18' height='18'>
                                <path class='ql-stroke' d='M4 5h16v14H4z M8 9h8 M8 13h5' stroke-width='1.7' stroke-linecap='round'/>
                            </svg>
                        `;
            
            toolbar.querySelector('.ql-rate').innerHTML = `
                            <svg viewBox='0 0 24 24' width='18' height='18'>
                                <circle class='ql-stroke' cx='12' cy='12' r='9' stroke-width='1.7'/>
                                <path class='ql-stroke' d='M15 8.5c-.7-.7-1.6-1-2.8-1-1.5 0-2.5.8-2.5 1.9 0 3 5.5 1.2 5.5 4.3 0 1.2-1.1 2.1-2.8 2.1-1.2 0-2.3-.4-3.1-1.2 M12 5.5v13'
                                    fill='none' stroke-width='1.5'
                                    stroke-linecap='round'/>
                            </svg>
                        `;
            
            let draft = localStorage.getItem('draft-post');
            if (draft) {
                draft = JSON.parse(draft);
                content = draft.content;
                quill.root.innerHTML = draft.content;
            }
            
            quill.on('text-change', () => {
                content = quill.root.innerHTML;
                if (validation['content']) delete validation['content'];
                saveDraft('post', { content });
            });"
            @submit.prevent="if (Object.keys(validation).length > 0) {
                    pushToastAlert(Object.values(validation)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(validation)[0]}']`).focus();
                } else if (!loading) {
                    loading = true;
                    axios.post($el.action, new FormData($el), {
                        headers: { 'Content-Type': 'multipart/form-data' }
                    }).then(r => {
                        if (r.data.success) {
                            localStorage.removeItem('draft-post');
                            window.location.href = r.data.redirect;
                        } else pushToastAlert(r.data.message, 'error');
                    }).catch(err => {
                        loading = false;
                        if (err.response && err.response.status === 422) validation = err.response.data.errors;
                    });
                }">
            @csrf

            <div>
                <x-inputs.input-label for="preview" :value="__('Preview')" />
                <x-inputs.file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp" required label="max. 5MB, 4/3" />
                <template x-if="validation.preview">
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.preview?.[0]"></p>
                </template>
            </div>

            <x-inputs.select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                ->keyBy('key')" />

            <x-inputs.editor name="content" class="mt-2 -mx-2 sm:-mx-4" />
            <template x-if="validation.content">
                <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.content?.[0]"></p>
            </template>

            <div class="xs:flex items-end">
                <div class="w-full">
                    <x-inputs.date-picker name="published_at" label="Publication date" type="datetime" min="today" :value="old('published_at')" />
                    <template x-if="validation.published_at">
                        <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.published_at?.[0]"></p>
                    </template>
                </div>

                <x-buttons.primary-button class="block mt-4 xs:mt-0 ml-auto xs:ml-3" ::disabled="loading"
                    ::class="loading ? 'opacity-50 cursor-progress' : ''">{{ __('Save') }}</x-buttons.primary-button>
            </div>

            <x-insight-toolbar-modal name="term" title="Attach a term" :clearable="false">
                <x-inputs.select name="term" label="Select a term" :items="$terms" />
            </x-insight-toolbar-modal>

            <x-insight-toolbar-modal name="rate" title="Attach a coin rate" :clearable="false">
                <x-inputs.select name="coin" label="Select a coin" :items="$coins" :icon="['type' => 'value', 'path' => '/storage/coins/']" />
            </x-insight-toolbar-modal>
        </form>
    </div>

    <x-slot name="rightSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
