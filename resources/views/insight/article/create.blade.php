<x-insight-layout title="Создание статьи | TM Insight" description="Создайте свою статью и обзор на сайте TrustMining | TM Insight" :header="__('Creation article')">
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
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            [{
                                'color': allowedTextColors
                            }, {
                                'background': allowedBackgroundColors
                            }],
                            [{
                                'align': []
                            }],
                            ['clean'],
                        ],
                        handlers: {
                            image: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                attachCallback = (src) => this.quill.updateContents(
                                    new Delta()
                                    .retain(range.index)
                                    .delete(range.length)
                                    .insert({ image: src }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', {
                                    detail: 'attach-img_modal'
                                }))
                            },
                            video: function() {
                                this.quill.focus();
                                const [range] = this.quill.selection.getRange();
            
                                attachCallback = (src) => this.quill.updateContents(
                                    new Delta()
                                    .retain(range.index)
                                    .delete(range.length)
                                    .insert({ video: src }),
                                    Quill.sources.USER,
                                );
            
                                window.dispatchEvent(new CustomEvent('open-modal', {
                                    detail: 'attach-video_modal'
                                }))
                            },
                        }
                    },
                },
                placeholder: '{{ __('Text of your article') }}',
                theme: 'snow'
            });
            
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
                    <p class="text-red-500 text-xs mt-1" x-text="validation.title?.[0]"></p>
                </template>
            </div>

            <div class="w-full">
                <x-inputs.input-label for="article-subtitle" :value="__('Brief description')" />
                <x-inputs.length-input id="article-subtitle" name="subtitle" type="text" x-model="subtitle" autocomplete="subtitle" required max="70"
                    @change="saveDraft('article', {title, subtitle, content})" />
                <template x-if="validation.subtitle">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.subtitle?.[0]"></p>
                </template>
            </div>

            <div>
                <x-inputs.input-label for="preview" :value="__('Preview')" />
                <x-inputs.file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp" required label="max. 5MB, 4/3" />
                <template x-if="validation.preview">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.preview?.[0]"></p>
                </template>
            </div>

            <x-inputs.select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                ->keyBy('key')" />

            <x-inputs.multiselect name="tags" label="Hashtags" :all="$tags" withAdding="true" />

            <template x-if="validation.tags">
                <p class="text-red-500 text-xs mt-1" x-text="validation.tags?.[0]"></p>
            </template>

            <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl mt-2 -mx-2 sm:-mx-4">
                <div id="editor"
                    class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200 focus:outline-0 p-4">
                </div>

                <input type="hidden" class="hidden" name="content" :value="content" required>
            </div>
            <template x-if="validation.content">
                <p class="text-red-500 text-xs mt-1" x-text="validation.content?.[0]"></p>
            </template>

            <x-buttons.primary-button class="block ml-auto" ::disabled="loading" ::class="loading ? 'opacity-50 cursor-progress' : ''">{{ __('Save') }}</x-buttons.primary-button>

            <x-modal name="attach-img_modal" maxWidth="md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg text-slate-800 dark:text-slate-200">
                            {{ __('Attach an image') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500" @click="show = false">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div>
                        <x-inputs.input-label for="attach-img_url" :value="__('Link to the image')" />
                        <x-inputs.text-input id="attach-img_url" type="text" autocomplete="attach-img_url" />
                    </div>

                    <x-buttons.primary-button id="attach-img_button" class="mt-2 sm:mt-4 block ml-auto" type="button"
                        @click="
                            show = false;
                            const input = $el.previousElementSibling.querySelector('input');
                            attachCallback(input.value);
                            input.value = null;
                            attachCallback = null;
                        ">
                        {{ __('Attach') }}
                    </x-buttons.primary-button>
                </div>
            </x-modal>

            <x-modal name="attach-video_modal" maxWidth="md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg text-slate-800 dark:text-slate-200">
                            {{ __('Attach a video') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500" @click="show = false">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div>
                        <x-inputs.input-label for="attach-video_url" :value="__('Link to the video') . ' (vkvideo, youtube, rutube)'" />
                        <x-inputs.text-input id="attach-video_url" type="text" autocomplete="attach-video_url" />
                    </div>

                    <x-buttons.primary-button class="mt-2 sm:mt-4 block ml-auto" type="button"
                        @click="
                            show = false;
                            const input = $el.previousElementSibling.querySelector('input');
                            attachCallback(processVideoLink(input.value));
                            input.value = null;
                            attachCallback = null;
                        ">
                        {{ __('Attach') }}
                    </x-buttons.primary-button>
                </div>
            </x-modal>
        </form>
    </div>

    <x-slot name="rightSidebar">
        <x-ai-kodex targetWidth="0" />
    </x-slot>
</x-insight-layout>
