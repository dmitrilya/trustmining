<x-app-layout title="Майнинг отель: создать объявление о хостинге"
    description="Создание объявления о хостинге на сайте TrustMining">
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

    <x-slot name="header">
        <h1 class="font-bold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Placement data') }}
        </h1>
    </x-slot>

    <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="p-4 sm:p-8 bg-white/40 dark:bg-slate-900/40 border border-slate-300 dark:border-slate-700 shadow shadow-logo-color rounded-lg">
            <p class="text-xxs sm:text-xs text-slate-600 mt-6">* - {{ __('required fields') }}</p>

            <form method="post" action="{{ route('hosting.store') }}" class="mt-2 space-y-6" enctype=multipart/form-data
                x-data="{ description: `{{ old('description') }}` }" x-init="const Delta = Quill.import('delta');
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
                
                quill.on('text-change', () => description = quill.root.innerHTML);">
                @csrf

                <div>
                    <x-input-label for="hosting-images" :value="'* ' . __('Photo')" />
                    <x-file-input id="hosting-images" name="images[]" class="mt-1 block w-full"
                        accept=".png,.jpg,.jpeg,.webp" multiple required
                        @change="if ($el.files.length > 10) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 10]) }}', 'error')}" />
                    <p class="mt-1 text-sm text-slate-600" id="images_help">PNG, JPG
                        or JPEG (max. 2MB, 10 items)</p>
                    <x-input-error :messages="$errors->get('images')" />
                    @foreach ($errors->get('images.*') as $error)
                        <x-input-error :messages="$error" />
                    @endforeach
                </div>

                <div class="relative mt-1" x-data="{ open: false, sugs: false }" @click.away="open = false">
                    <div class="relative z-0 w-full group" @click="open = true">
                        <input type="text" id="address" name="address" x-ref="search" placeholder=" "
                            @input.debounce.1000ms="sugs = dadataSuggs($el.value, $refs.suggestionList, open, 'address')"
                            autocomplete="off"
                            class="block py-2.5 px-0 w-full text-sm text-slate-950 bg-transparent border-0 border-b-2 border-slate-300 appearance-none dark:text-white dark:border-slate-700 dark:focus:border-indigo-500 focus:outline-none focus:ring-0 focus:border-indigo-500 peer" />
                        <label for="address"
                            class="absolute text-sm text-slate-600 dark:text-slate-300 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-600 peer-focus:dark:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                            {{ __('Address of the territory') }}
                        </label>
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <ul role="listbox" style="display: none" x-show="open && sugs" x-ref="suggestionList"
                        class="absolute z-10 mt-1 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg shadow-logo-color ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    </ul>
                </div>

                <div>
                    <x-input-label for="video" :value="__('Link to video')" />
                    <x-text-input id="video" name="video" type="text" :value="old('video')" autocomplete="video" />
                    <x-input-error :messages="$errors->get('video')" />
                </div>

                <x-peculiarities model="hosting" :isForm="true"></x-peculiarities>

                <x-editable-list name="conditions">
                    <x-input-label :value="__('Conditions (from N units, from N th, etc.)')" />
                </x-editable-list>

                <x-editable-list name="expenses">
                    <x-input-label :value="__('Additional costs (e.g. delivery to the territory)')" />
                </x-editable-list>

                <div id="editor-wrap" class="bg-slate-100 dark:bg-slate-950 rounded-xl">
                    <div id="editor"
                        class="!border-t border-slate-300 dark:border-slate-700 text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-100 focus:outline-0 p-4">
                    </div>

                    <input type="hidden" class="hidden" name="description" :value="description" required>
                </div>
                <x-input-error :messages="$errors->get('description')" />

                <div>
                    <x-input-label for="hosting-contract" :value="'* ' . __('Agreement for the provision of accommodation services')" />
                    <x-file-input id="hosting-contract" name="contract" class="mt-1 block w-full" required
                        accept=".doc,.docx" />
                    <p class="mt-1 text-sm text-slate-600" id="contract_help">DOC (max. 1MB)</p>
                    <x-input-error :messages="$errors->get('contract')" />
                </div>

                <div>
                    <x-input-label for="hosting-territory" :value="__('Rights to the territory (rent, ownership)')" />
                    <x-file-input id="hosting-territory" name="territory" class="mt-1 block w-full"
                        accept=".doc,.docx" />
                    <p class="mt-1 text-sm text-slate-600" id="territory_help">DOC (max. 1MB)</p>
                    <x-input-error :messages="$errors->get('territory')" />
                </div>

                <div>
                    <x-input-label for="hosting-energy_supply" :value="__('Energy supply agreement')" />
                    <x-file-input id="hosting-energy_supply" name="energy_supply" class="mt-1 block w-full"
                        autocomplete="energy_supply" accept=".doc,.docx" :value="old('energy_supply')" />
                    <p class="mt-1 text-sm text-slate-600" id="energy_supply_help">DOC (max. 1MB)</p>
                    <x-input-error :messages="$errors->get('energy_supply')" />
                </div>

                <div>
                    <x-input-label for="price" :value="'* ' . __('Tariff')" />
                    <x-text-input id="price" name="price" required autocomplete="price" min="1"
                        max="10" type="number" step="0.01" :value="old('price')" />
                    <x-input-error :messages="$errors->get('price')" />
                </div>

                <x-primary-button class="block ml-auto">{{ __('Save') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-app-layout>
