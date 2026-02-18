<x-app-layout title="Задать вопрос на форуме TrustMining"
    description="Опишите свою проблему или начните обсуждение интересующей вас темы из криптосферы">
    <x-slot name="header">
        <h1 class="font-bold text-xl text-gray-900 dark:text-gray-100 leading-tight">
            {{ __('Question creating') }}
        </h1>
    </x-slot>

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-8">
        <div
            class="w-full h-full bg-white/60 dark:bg-zinc-900/60 border border-gray-300 dark:border-zinc-700 border border-gray-300 dark:border-zinc-800 rounded-2xl shadow-lg shadow-logo-color">
            @if (!Auth::user())
                <div class="flex items-center justify-center w-full h-full">
                    <a href="{{ route('login') }}"><x-primary-button>{{ __('Sign in') }}</x-primary-button></a>
                </div>
            @else
                <form action="{{ route('forum.question.store') }}" method="POST" x-data="{ theme: `{{ old('theme') }}`, text: `{{ old('text') }}`, range: null, link_text: null, link_url: null }"
                    @submit.prevent="if (theme.length > 64) return window.pushToastAlert('{{ __('The maximum theme length is 64 characters') }}', 'error');
                        if (text.length > 3000) return window.pushToastAlert('{{ __('The maximum question length is 3000 characters.') }}', 'error'); $el.submit()"
                    enctype=multipart/form-data>
                    @csrf

                    <div>
                        <x-text-input class="!mt-0 !ring-0 px-4 py-4 rounded-t-2xl dark:placeholder-gray-400" required
                            id="theme" name="theme" type="text" autocomplete="off" @change="theme = $el.value"
                            placeholder="{{ __('Theme') }}" ::value="theme" aria-label="{{ __('Theme') }}" />
                        <x-input-error :messages="$errors->get('theme')" />
                    </div>

                    <div class="px-4 py-2 mt-6 bg-white dark:bg-zinc-950 rounded-t-lg">
                        <input type="hidden" name="text" :value="text">
                        <pre required id="text" aria-placeholder="{{ __('Your question...') }}" x-ref="question" contenteditable="true"
                            class="whitespace-normal resize-none w-full px-0 text-gray-950 dark:text-gray-200 bg-white border-0 dark:bg-zinc-950 focus:ring-0 focus-visible:ring-0 focus-visible:outline-none dark:placeholder-gray-400"
                            style="min-height: 96px" @input="text = $el.innerHTML; range = saveRange()" @keyup="range = saveRange()"
                            @mouseup="range = saveRange()" @touchend="range = saveRange()" @paste="e => formatPaste($el, e)"></pre>
                        <x-input-error :messages="$errors->get('text')" />
                    </div>

                    <div class="flex items-center justify-between px-3 py-2 border-t dark:border-zinc-700"
                        x-data="{ images: 0, files: 0 }">
                        <div class="flex ps-0 space-x-1 rtl:space-x-reverse">
                            <label for="input-file-question"
                                class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                                <input id="input-file-question" name="files[]" class="hidden" type="file"
                                    accept=".pdf,.doc,.docx,.txt" multiple
                                    @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')};files = $el.files.length">
                                <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 12 20">
                                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                                        d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                                </svg>
                                <span class="sr-only">Attach file</span>
                            </label>

                            <label for="input-image-question"
                                class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                                <input id="input-image-question" name="images[]" class="hidden" type="file"
                                    accept=".png,.jpg,.jpeg,.webp" multiple
                                    @change="if ($el.files.length > 5) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 5]) }}', 'error')};images = $el.files.length">
                                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 18">
                                    <path
                                        d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                                </svg>
                                <span class="sr-only">Upload image</span>
                            </label>

                            <div @click="$dispatch('open-modal', 'create-question-link');link_text = prepareLink(range, $refs.question)"
                                aria-label="Create hyperlink"
                                class="inline-flex justify-center items-center p-1 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                                <svg class="size-5" aria-hidden="true" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
                                </svg>
                            </div>

                            <x-modal name="create-question-link" maxWidth="sm">
                                <div class="p-4">
                                    <h3 class="text-lg text-gray-950 dark:text-gray-50 mb-6">
                                        {{ __('Create link') }}
                                    </h3>

                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="text" id="hyper" placeholder=" " :value="link_text"
                                            @change="link_text = $el.value"
                                            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-gray-700 dark:text-gray-300 border-gray-300 dark:border-zinc-700 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                        <label for="hyper"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            {{ __('Text') }}
                                        </label>
                                    </div>

                                    <div class="relative z-0 w-full mb-5 group">
                                        <input type="url" id="url" placeholder=" " :value="link_url"
                                            @change="link_url = $el.value"
                                            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-gray-700 dark:text-gray-300 border-gray-300 dark:border-zinc-700 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
                                        <label for="url"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                            URL
                                        </label>
                                    </div>

                                    <div class="mt-2 sm:mt-4 flex justify-end">
                                        <x-secondary-button @click="$dispatch('close')" class="mr-2 sm:mr-3">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-primary-button type="button"
                                            @click="() => {insertLink(range, $refs.question, link_text, link_url);$dispatch('close')}">{{ __('Save') }}</x-primary-button>
                                    </div>
                                </div>
                            </x-modal>

                            <x-dropdown align="bottom" width="auto">
                                <x-slot name="trigger">
                                    <button type="button" data-dropdown-placement="top"
                                        class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                                        <span>&#128516</span>
                                        <span class="sr-only">Add emoji</span>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-2 py-1 grid grid-cols-5 h-60 overflow-y-auto emoji-container"
                                        @click="e => {if (e.target.classList.contains('chat-emoji')) insertEmoji(range, $refs.question, e.target.innerHTML);}">
                                        @include('chat.components.emoji')
                                    </div>
                                </x-slot>
                            </x-dropdown>

                            <div class="flex flex-col justify-center ml-2">
                                <div class="text-xxs sm:text-xs text-gray-500"
                                    style="display: hidden" x-show="files > 0">
                                    {{ __('File') }}: <span class="text-gray-700 dark:text-gray-300"
                                        x-text="files"></span>
                                </div>
                                <div class="text-xxs sm:text-xs text-gray-500" style="display: hidden"
                                    x-show="images > 0">
                                    {{ __('Image') }}: <span class="text-gray-700 dark:text-gray-300"
                                        x-text="images"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="send_button" @click="$el.classList.add('hidden')"
                            class="inline-flex items-center py-2.5 px-4 text-xs text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-700 hover:bg-indigo-700">
                            {{ __('Send') }}
                        </button>
                    </div>

                    @if (count($errors->get('images.*')))
                        <div class="px-3 py-2">
                            @foreach ($errors->get('images.*') as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                        </div>
                    @endif

                    @if (count($errors->get('files.*')))
                        <div class="px-3 py-2">
                            @foreach ($errors->get('files.*') as $error)
                                <x-input-error :messages="$error" />
                            @endforeach
                        </div>
                    @endif
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
