<x-app-layout title="Редактировать информацию о компании"
    description="Добавьте описание, фото и логотип к своей компании на сайте TrustMining" noindex="true">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ $company->name }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="p-4 sm:p-8 bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 shadow shadow-logo-color rounded-lg">
            <form method="post" action="{{ route('company.update', ['company' => $company->id]) }}"
                class="mt-6 space-y-6" enctype=multipart/form-data x-data="{ description: `{{ old('description') }}` }" x-init="const Delta = Quill.import('delta');
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
                                ['bold', { 'list': 'bullet' }],
                            ]
                        }
                    },
                    placeholder: '{{ __('Description') }}...',
                    theme: 'snow'
                });
                
                quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => {
                    delta.ops.forEach(op => {
                        if (op.attributes?.color) delete op.attributes.color;
                        if (op.attributes?.background) delete op.attributes.background;
                    });
                
                    return delta;
                });
                
                quill.root.innerHTML = `{{ $company->description }}`;
                
                quill.on('text-change', () => description = quill.root.innerHTML);">
                @method('put')
                @csrf

                <div>
                    <x-input-label for="company" :value="__('Company TIN')" />
                    <x-text-input id="company" readonly disabled autocomplete="company"
                        value="{{ $company->card['inn'] }}" />
                </div>

                <div>
                    <x-input-label for="images" :value="__('Photo')" />
                    <x-file-input id="images" name="images[]" class="mt-1 block w-full"
                        accept=".png,.jpg,.jpeg,.webp" multiple
                        @change="if ($el.files.length > 8) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 8]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-gray-600" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 8 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <div>
                    <x-input-label for="logo" :value="__('Logo for avatar')" />
                    <x-file-input id="logo" name="logo" class="mt-1 block w-full"
                        accept=".png,.jpg,.jpeg,.webp" />
                    <p class="mt-1 text-sm text-gray-600" id="logo_help">PNG, JPG
                        or JPEG (max. 512KB, 1x1)</p>
                    <x-input-error :messages="$errors->get('logo')" />
                </div>

                <div>
                    <x-input-label for="bg_logo" :value="__('Logo for the card')" />
                    <x-file-input id="bg_logo" name="bg_logo" class="mt-1 block w-full"
                        accept=".png,.jpg,.jpeg,.webp" />
                    <p class="mt-1 text-sm text-gray-600" id="bg_logo_help">PNG, JPG
                        or JPEG (max. 1024KB)</p>
                    <x-input-error :messages="$errors->get('bg_logo')" />
                </div>

                <div id="editor-wrap" class="bg-gray-100 dark:bg-zinc-950 rounded-xl">
                    <div id="editor"
                        class="!border-t border-gray-300 dark:border-zinc-700 text-xs xs:text-sm sm:text-base text-gray-800 dark:text-gray-100 focus:outline-0 p-4">
                    </div>

                    <input type="hidden" class="hidden" name="description" :value="description" required>
                </div>
                <x-input-error :messages="$errors->get('description')" />

                @if ($company->user->tariff && $company->user->tariff->can_site_link)
                    <div>
                        <x-input-label for="site" :value="__('Link to site')" />
                        <x-text-input id="site" name="site" type="text" :value="$company->site"
                            autocomplete="site" />
                        <x-input-error :messages="$errors->get('site')" />
                    </div>
                @endif

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="$company->video"
                        autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
