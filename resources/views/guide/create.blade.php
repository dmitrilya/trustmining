<x-app-layout title="Создание статьи/руководства" description="Создайте свою статью и обзор на сайте TrustMining">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Creating article/guide') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8" x-data="{ addImg: false, addVideo: false }">
        <div class="p-4 sm:p-8 bg-white dark:bg-zinc-900 shadow rounded-lg">
            <form action="{{ route('guide.store') }}" method="POST" class="space-y-6" enctype=multipart/form-data>
                @csrf

                <div>
                    <x-input-label for="title" :value="__('Title') . ' (max 40)'" />
                    <x-text-input id="title" name="title" type="text" :value="old('title')" autocomplete="title"
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
                    <x-text-input id="subtitle" name="subtitle" type="text" max="100" :value="old('subtitle')"
                        autocomplete="subtitle"
                        @input="if ($el.value.length > 100) {$el.value=$el.value.substring(0, 100);return pushToastAlert('{{ __('validation.max.array', ['max' => 100]) }}', 'error')}" />
                    <x-input-error :messages="$errors->get('subtitle')" />
                </div>

                <x-editable-list name="tags">
                    <p class="block text-sm text-gray-800 dark:text-gray-300">{{ __('Tags for search') }}</p>
                </x-editable-list>
                <x-input-error :messages="$errors->get('tags')" />

                <div class="mt-5" style="background:inherit;">
                    @include('guide.components.format.panel', [
                        'blocks' => ['emoji', 'color', 'size', 'style', 'hilite', 'align', 'media', 'word_count'],
                    ])

                    <div class="bg-gray-100 dark:bg-zinc-950 rounded-lg">
                        <pre contenteditable @input="$refs.guide.value=$el.innerHTML"
                            class="whitespace-break-spaces text-xs sm:text-sm text-gray-800 dark:text-gray-100 border-0 focus:border-0 focus:outline-0 px-3 py-2"></pre>
                        <input type="hidden" x-ref="guide" class="hidden" name="guide" value="">
                    </div>
                    <x-input-error :messages="$errors->get('guide')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>

        <x-modal name="attach-img_modal" maxWidth="md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg text-gray-950 dark:text-gray-50">
                        {{ __('Attach a picture') }}
                    </h2>

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
                    @click="show = false;formatAttachMedia('img')">{{ __('Attach') }}</x-primary-button>
            </div>
        </x-modal>

        <x-modal name="attach-video_modal" maxWidth="md">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg text-gray-950 dark:text-gray-50">
                        {{ __('Attach a video') }}
                    </h2>

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
                    @click="show = false;formatAttachMedia('video')">{{ __('Attach') }}</x-primary-button>
            </div>
        </x-modal>
    </div>
</x-app-layout>
