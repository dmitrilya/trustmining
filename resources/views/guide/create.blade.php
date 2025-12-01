<x-app-layout title="Создание статьи/руководства">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Creating article/guide') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
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
                        accept=".png,.jpg,.jpeg" />
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
                    <x-input-label :value="__('Tags for search')" />
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
    </div>
</x-app-layout>
