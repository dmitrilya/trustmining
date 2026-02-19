<x-insight-layout title="Создание статьи | TM Insight"
    description="Создайте свою статью и обзор на сайте TrustMining | TM Insight" :header="__('Creation article')">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <div x-data="{ content: `{{ old('content') }}`, attachCallback: null }" x-init="const Delta = Quill.import('delta');
    const ColorClass = Quill.import('attributors/class/color');
    Quill.register(ColorClass, true);
    const BackgroundClass = Quill.import('attributors/class/background');
    Quill.register(BackgroundClass, true);
    
    const allowedTextColors = ['main-text-color', 'secondary-text-color'];
    const allowedBackgroundColors = ['green-bg-color', 'indigo-bg-color'];

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
    
    quill.on('text-change', () => content = quill.root.innerHTML);">
        <div
            class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-xl">
            <form action="{{ route('insight.article.store', ['channel' => $channel->slug]) }}" method="POST"
                class="flex flex-col gap-4" enctype=multipart/form-data x-data="{ errors: [] }"
                @submit.prevent="if (Object.keys(errors).length > 0) {
                    pushToastAlert(Object.values(errors)[0], 'error');
                    $el.querySelector(`[name='${Object.keys(errors)[0]}']`).focus();
                } else $el.submit();">
                @csrf

                <div class="w-full">
                    <x-input-label for="article-title" :value="__('Title')" />
                    <x-length-input id="article-title" name="title" type="text" :value="old('title')"
                        autocomplete="title" required max="40" />
                    <x-input-error :messages="$errors->get('title')" />
                </div>

                <div class="w-full">
                    <x-input-label for="article-subtitle" :value="__('Brief description')" />
                    <x-length-input id="article-subtitle" name="subtitle" type="text" :value="old('subtitle')"
                        autocomplete="subtitle" required max="70" />
                    <x-input-error :messages="$errors->get('subtitle')" />
                </div>

                <div>
                    <x-input-label for="preview" :value="__('Preview')" />
                    <x-file-input id="preview" name="preview" class="mt-1 block w-full" accept=".png,.jpg,.jpeg,.webp"
                        required />
                    <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
                        or JPEG (max. 2MB), dimensions:ratio=4/3</p>
                    <x-input-error :messages="$errors->get('preview')" />
                </div>

                <x-select :label="__('Series')" name="series_id" :items="collect([['key' => 0, 'value' => __('Without series')]])
                    ->concat($channel->series->map(fn($series) => ['key' => $series->id, 'value' => $series->name]))
                    ->keyBy('key')" />

                <x-editable-list name="tags">
                    <p class="block text-sm text-gray-700 dark:text-gray-300">{{ __('Tags for search') }}</p>
                </x-editable-list>
                <x-input-error :messages="$errors->get('tags')" />

                <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-xl mt-2 -mx-2 sm:-mx-4">
                    <div id="editor"
                        class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-4">
                    </div>

                    <input type="hidden" class="hidden" name="content" :value="content" required>
                </div>
                <x-input-error :messages="$errors->get('content')" />

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>

            <x-modal name="attach-img_modal" maxWidth="md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg text-gray-950 dark:text-gray-50">
                            {{ __('Attach an image') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-zinc-950 text-gray-500"
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
                        <h3 class="text-lg text-gray-950 dark:text-gray-50">
                            {{ __('Attach a video') }}
                        </h3>

                        <button type="button" aria-label="{{ __('Close') }}"
                            class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-zinc-950 text-gray-500"
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
