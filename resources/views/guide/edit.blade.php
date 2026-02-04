<form action="{{ route('guide.update', ['guide' => $guide->id]) }}" method="POST" class="space-y-6" enctype=multipart/form-data>
    @csrf
    @method('PUT')

    <div>
        <x-input-label for="title" :value="__('Title') . ' (max 40)'" />
        <x-text-input id="title" name="title" type="text" :value="$guide->title" autocomplete="title" required
            @input="if ($el.value.length > 40) {$el.value=$el.value.substring(0, 40);return pushToastAlert('{{ __('validation.max.array', ['max' => 40]) }}', 'error')}" />
        <x-input-error :messages="$errors->get('title')" />
    </div>

    <div>
        <x-input-label for="preview" :value="__('Preview')" />
        <x-file-input id="preview" name="preview" class="mt-1 block w-full" autocomplete="preview"
            accept=".png,.jpg,.jpeg,.webp" />
        <p class="mt-1 text-sm text-gray-600" id="file_input_help">PNG, JPG
            or JPEG (max. 2MB), dimensions:ratio=4/3</p>
        <x-input-error :messages="$errors->get('preview')" />
    </div>

    <div>
        <x-input-label for="subtitle" :value="__('Brief description') . ' (max 100)'" />
        <x-text-input id="subtitle" name="subtitle" type="text" max="100" :value="$guide->subtitle"
            autocomplete="subtitle" required
            @input="if ($el.value.length > 100) {$el.value=$el.value.substring(0, 100);return pushToastAlert('{{ __('validation.max.array', ['max' => 100]) }}', 'error')}" />
        <x-input-error :messages="$errors->get('subtitle')" />
    </div>

    <x-editable-list name="tags" :items="$guide->tags">
        <p class="block text-sm text-gray-800 dark:text-gray-300">{{ __('Tags for search') }}</p>
    </x-editable-list>
    <x-input-error :messages="$errors->get('tags')" />

    <div class="mt-5" style="background:inherit;" x-data="{ text: `{{ old('guide') }}`, quill: null, Delta: Quill.import('delta'), attachCallback: null }" x-init="const Parchment = Quill.import('parchment');
    const MyColorClass = new Parchment.Attributor('color', 'class', {
        scope: Parchment.Scope.INLINE,
        whitelist: ['ql-color-main-text-color', 'ql-color-secondary-text-color']
    });
    
    const MyBackgroundClass = new Parchment.Attributor('background', 'class', {
        scope: Parchment.Scope.INLINE,
        whitelist: ['ql-bg-green-bg-color', 'ql-bg-indigo-bg-color']
    });
    
    Quill.register(MyColorClass, true);
    Quill.register(MyBackgroundClass, true);
    
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
                    [{
                        'size': ['small', false, 'large', 'huge']
                    }],
                    ['bold', 'italic', 'underline'],
                    ['blockquote', 'code-block'],
                    ['link', 'image', 'video', 'table'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'color': ['ql-color-main-text-color', 'ql-color-secondary-text-color']
                    }, {
                        'background': ['ql-bg-green-bg-color', 'ql-bg-indigo-bg-color']
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
        placeholder: 'Compose an epic...',
        theme: 'snow'
    });
    
    quill.root.innerHTML = '{{ $guide->guide }}';
    
    quill.clipboard.addMatcher(
        Node.ELEMENT_NODE,
        (node, delta) => new Delta().insert(node.innerText || node.textContent)
    );
    
    quill.on('text-change', () => text = quill.root.innerHTML);">
        <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-lg -mx-2 sm:-mx-4">
            <div id="editor"
                class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-2 sm:p-4">
            </div>

            <input type="hidden" class="hidden" name="guide" :value="text" required>
        </div>
        <x-input-error :messages="$errors->get('guide')" />
    </div>

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
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
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
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
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
