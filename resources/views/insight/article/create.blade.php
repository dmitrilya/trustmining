<x-insight-layout title="Создание статьи | TM Insight"
    description="Создайте свою статью и обзор на сайте TrustMining | TM Insight" :header="__('Creation article')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div x-data="{
        content: `{{ old('content') }}`,
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
    
    if (localStorage.getItem('draft')) quill.root.innerHTML = localStorage.getItem('draft');
    
    const draft = debounce(() => {
        localStorage.setItem('draft', content);
    }, 1500);
    
    quill.on('text-change', () => {
        content = quill.root.innerHTML;
        draft();
    });">
        <div
            class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-xl">
            <form action="{{ route('insight.article.store', ['channel' => $channel->slug]) }}" method="POST"
                class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ errors: [], validation: [], loading: false }"
                @submit.prevent="if (Object.keys(errors).length > 0) {
                    pushToastAlert(Object.values(errors)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
                } else if (!loading) {
                    loading = true;
                    axios.post($el.action, new FormData($el), {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(r => {
                        if (r.data.success) {
                            localStorage.removeItem('draft'); 
                            window.location.href = r.data.redirect;
                        }
                    }).catch(err => {
                        loading = false;
                        if (err.response && err.response.status === 422) {
                            validation = err.response.data.errors;
                        }
                    });
                }">
                @csrf

                <div class="w-full">
                    <x-input-label for="article-title" :value="__('Title')" />
                    <x-length-input id="article-title" name="title" type="text" :value="old('title')"
                        autocomplete="title" required max="40" />
                    <x-input-error :messages="$errors->get('title')" />
                    <template x-if="validation.title">
                        <p class="text-red-500 text-xs mt-1" x-text="validation.title[0]"></p>
                    </template>
                </div>

                <div class="w-full">
                    <x-input-label for="article-subtitle" :value="__('Brief description')" />
                    <x-length-input id="article-subtitle" name="subtitle" type="text" :value="old('subtitle')"
                        autocomplete="subtitle" required max="70" />
                    <x-input-error :messages="$errors->get('subtitle')" />
                    <template x-if="validation.subtitle">
                        <p class="text-red-500 text-xs mt-1" x-text="validation.subtitle[0]"></p>
                    </template>
                </div>

                <div>
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                        required />
                    <p class="mt-1 text-sm text-slate-600" id="file_input_help">PNG, JPG
                        or JPEG (max. 5MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                    <template x-if="validation.preview">
                        <p class="text-red-500 text-xs mt-1" x-text="validation.preview[0]"></p>
                    </template>
                </div>

                <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                    ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                    ->keyBy('key')" />

                <div x-data="{ allTags: {{ $tags }}, tags: [], search: '' }">
                    <div>
                        <x-input-label for="search" :value="__('Hashtags')" />
                        <div @if (!auth()->check()) @click="$dispatch('open-modal', 'login')" @endif
                            class="mt-1 flex items-center overflow-hidden bg-white dark:bg-slate-950 rounded-md shadow-sm shadow-logo-color ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500 pr-2">
                            <input type="text" id="search" x-model="search" placeholder="#"
                                class="py-1.5 px-3 bg-transparent border-0 focus:ring-0 text-slate-700 dark:text-slate-300 w-full" />

                            <button type="button"
                                class="text-xs bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 hover:dark:bg-slate-700 shadow-sm text-slate-700 dark:text-slate-300 px-2 py-1 rounded-full"
                                @click="if (!search.trim().length) return; tags.push(search); if (allTags.indexOf(search) != -1) allTags.splice(allTags.indexOf(search), 1); search = ''">{{ __('Add') }}</button>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                        <template x-for="tag in tags" :key="tag">
                            <div @click="tags.splice(tags.indexOf(tag), 1);allTags.push(tag)" x-text="tag"
                                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-indigo-600 hover:bg-indigo-500 dark:hover:bg-slate-800 text-white text-xxs sm:text-xs">
                            </div>
                        </template>
                    </div>

                    <div class="flex flex-wrap gap-0.5 sm:gap-1 mt-2">
                        <template
                            x-for="tag in allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).slice(0, 15)"
                            :key="tag">
                            <div @click="tags.push(tag);allTags.splice(allTags.indexOf(tag), 1);search = ''"
                                x-text="tag"
                                class="cursor-pointer px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
                            </div>
                        </template>
                        <div x-show="allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).length > 15"
                            class="px-1 py-0.5 sm:px-2 sm:py-1 rounded-md bg-slate-50 dark:bg-slate-950 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-100 text-xxs sm:text-xs">
                            <span
                                x-text="allTags.filter(allTag => `${allTag}`.toLowerCase().indexOf(search.toLowerCase()) !== -1).length - 15"></span>
                            {{ __('tags more') }}
                        </div>
                    </div>

                    <template x-for="tag in tags" :key="tag">
                        <input type="hidden" name="tags[]" :value="tag">
                    </template>
                </div>
                <x-input-error :messages="$errors->get('tags')" />
                <template x-if="validation.tags">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.tags[0]"></p>
                </template>

                <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl mt-2 -mx-2 sm:-mx-4">
                    <div id="editor"
                        class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-100 focus:outline-0 p-4">
                    </div>

                    <input type="hidden" class="hidden" name="content" :value="content" required>
                </div>
                <x-input-error :messages="$errors->get('content')" />
                <template x-if="validation.content">
                    <p class="text-red-500 text-xs mt-1" x-text="validation.content[0]"></p>
                </template>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>

            <x-modal name="attach-img_modal" maxWidth="md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg text-slate-950 dark:text-slate-50">
                            {{ __('Attach an image') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                            @click="show = false">
                            <span class="sr-only">Close</span>
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div>
                        <x-input-label for="attach-img_url" :value="__('Link to the image')" />
                        <x-text-input id="attach-img_url" type="text" autocomplete="attach-img_url" />
                    </div>

                    <x-primary-button id="attach-img_button" class="mt-2 sm:mt-4 block ml-auto"
                        @click="
                            show = false;
                            const input = $el.previousElementSibling.querySelector('input');
                            attachCallback(input.value);
                            input.value = null;
                            attachCallback = null;
                        ">
                        {{ __('Attach') }}
                    </x-primary-button>
                </div>
            </x-modal>

            <x-modal name="attach-video_modal" maxWidth="md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg text-slate-950 dark:text-slate-50">
                            {{ __('Attach a video') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                            @click="show = false">
                            <span class="sr-only">Close</span>
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div>
                        <x-input-label for="attach-video_url" :value="__('Link to the video') . ' (vkvideo, youtube, rutube)'" />
                        <x-text-input id="attach-video_url" type="text" autocomplete="attach-video_url" />
                    </div>

                    <x-primary-button class="mt-2 sm:mt-4 block ml-auto"
                        @click="
                            show = false;
                            const input = $el.previousElementSibling.querySelector('input');
                            attachCallback(processVideoLink(input.value));
                            input.value = null;
                            attachCallback = null;
                        ">
                        {{ __('Attach') }}
                    </x-primary-button>
                </div>
            </x-modal>
        </div>
    </div>
</x-insight-layout>
