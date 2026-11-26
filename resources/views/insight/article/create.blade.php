<x-insight-layout :title="__('meta.insight.content.article.create.title')" :description="__('meta.insight.content.article.create.description')" :header="__('meta.insight.content.article.create.header')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
        <form action="{{ route('insight.article.store', ['channel' => $channel->slug]) }}" method="POST" class="flex flex-col gap-4" enctype=multipart/form-data
            x-data="{
                validation: [],
                loading: false,
                title: null,
                subtitle: null,
                content: null,
                attachCallback: null
            }" x-init="const Delta = Quill.import('delta');
            const Parchment = Quill.import('parchment');
            
            const allowedTextColors = ['ql-color-main-text-color', 'ql-color-secondary-text-color'];
            const allowedBackgroundColors = ['ql-bg-green-bg-color', 'ql-bg-indigo-bg-color'];
            
            const MyColorClass = new Parchment.Attributor('color', 'class', {
                scope: Parchment.Scope.INLINE,
                whitelist: allowedTextColors
            });
            
            const MyBackgroundClass = new Parchment.Attributor('background', 'class', {
                scope: Parchment.Scope.INLINE,
                whitelist: allowedBackgroundColors
            });
            
            Quill.register(MyColorClass, true);
            Quill.register(MyBackgroundClass, true);
            
            const Inline = Quill.import('blots/inline');
            
            class CustomSpan extends Inline {
                static create(value) {
                    let node = super.create();
                    node.setAttribute('class', value);
                    return node;
                }
                static formats(node) {
                    return node.getAttribute('class');
                }
            }
            
            CustomSpan.blotName = 'customSpan';
            CustomSpan.tagName = 'span';
            Quill.register(CustomSpan);
            
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
                    node.style.setProperty('--coin-url', `url(/storage/coins/${value}.webp)`);
                    return node;
                }
            
                static formats(node) {
                    return node.getAttribute('data-coin');
                }
            
                format(name, value) {
                    if (name === 'rate' && value) {
                        this.domNode.setAttribute('data-coin', value);
                        this.domNode.style.setProperty('--coin-url', `url(/storage/coins/${value}.webp)`);
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
            
            const Image = Quill.import('formats/image');
            Image.className = 'quill-embed-image';
            Quill.register(Image, true);
            
            const Video = Quill.import('formats/video');
            Video.className = 'quill-embed-video';
            Quill.register(Video, true);
            
            quill = new Quill('#editor', {
                modules: {
                    toolbar: {
                        container: [
                            [{ 'header': [2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            ['blockquote', 'code-block'],
                            ['link', 'image', 'video', 'table'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'color': allowedTextColors }, { 'background': allowedBackgroundColors }],
                            [{ 'align': [] }],
                            ['term', 'rate'],
                            ['clean'],
                        ],
                        handlers: {
                            image: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                attachCallback = (src) => this.quill.updateContents(
                                    new Delta().retain(range.index).delete(range.length).insert({ image: src }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'attach-img_modal' }));
                            },
                            video: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                attachCallback = (src) => this.quill.updateContents(
                                    new Delta().retain(range.index).delete(range.length).insert({ video: src }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'attach-video_modal' }));
                            },
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
                },
                placeholder: '{{ __('Text of your article') }}',
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
            
            quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
                delta.ops.forEach(op => {
                    if (op.attributes?.color && !allowedTextColors.includes(op.attributes.color))
                        delete op.attributes.color;
                    if (op.attributes?.background && !allowedBackgroundColors.includes(op.attributes.background))
                        delete op.attributes.background;
                });
            
                return delta;
            });
            
            let draft = localStorage.getItem('draft-article');
            if (draft) {
                draft = JSON.parse(draft);
                title = draft.title;
                subtitle = draft.subtitle;
                content = draft.content;
                quill.clipboard.dangerouslyPasteHTML(0, draft.content);
            }
            
            quill.on('text-change', () => {
                content = quill.root.innerHTML;
                if (validation['content']) delete validation['content'];
                saveDraft('article', { title, subtitle, content });
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
                            localStorage.removeItem('draft-article'); 
                            window.location.href = r.data.redirect;
                        } else pushToastAlert(r.data.message, 'error');
                    }).catch(err => {
                        loading = false;
                        if (err.response && err.response.status === 422) validation = err.response.data.errors;
                    });
                }">
            @csrf

            <div class="w-full">
                <x-inputs.input-label for="article-title" :value="__('Title')" />
                <x-inputs.length-input id="article-title" name="title" type="text" x-model="title" autocomplete="title" required max="40"
                    @change="saveDraft('article', {title, subtitle, content})" />
                <template x-if="validation.title">
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.title?.[0]"></p>
                </template>
            </div>

            <div class="w-full">
                <x-inputs.input-label for="article-subtitle" :value="__('Brief description')" />
                <x-inputs.length-input id="article-subtitle" name="subtitle" type="text" x-model="subtitle" autocomplete="subtitle" required max="70"
                    @change="saveDraft('article', {title, subtitle, content})" />
                <template x-if="validation.subtitle">
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.subtitle?.[0]"></p>
                </template>
            </div>

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

            <x-inputs.multiselect name="tags" label="Hashtags" :all="$tags" withAdding="true" />

            <template x-if="validation.tags">
                <p class="text-red-600 dark:text-red-400 text-xs mt-1" x-text="validation.tags?.[0]"></p>
            </template>

            <x-inputs.editor name="content" class="mt-2 -mx-2 sm:-mx-4 [user-select:element] [-webkit-user-select:element]" />
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

            <x-insight-toolbar-modal name="img" title="Attach an image">
                <div>
                    <x-inputs.input-label for="attach-img_url" :value="__('Link to the image')" />
                    <x-inputs.text-input id="attach-img_url" type="text" autocomplete="attach-img_url" />
                </div>
            </x-insight-toolbar-modal>

            <x-insight-toolbar-modal name="video" title="Attach a video">
                <div>
                    <x-inputs.input-label for="attach-video_url" :value="__('Link to the video') . ' (vkvideo, youtube, rutube)'" />
                    <x-inputs.text-input id="attach-video_url" type="text" autocomplete="attach-video_url" />
                </div>
            </x-insight-toolbar-modal>

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
