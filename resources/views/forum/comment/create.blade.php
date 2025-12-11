<form action="{{ route('forum.comment.store') }}" method="POST" x-data="{ text: `{{ old('text') }}` }"
    @submit.prevent="if (text.length > 1500) return window.pushToastAlert('{{ __('The maximum comment length is 1500 characters.') }}', 'error');$el.submit()"
    enctype=multipart/form-data class="bg-gray-50 dark:bg-zinc-950 rounded-xl">
    @csrf

    <input type="hidden" name="forum_answer_id" value="{{ $answer->id }}">

    <div class="px-4 py-2 bg-gray-50 dark:bg-zinc-950 rounded-t-lg">
        <label for="text" class="sr-only">{{ __('Your comment...') }}</label>
        <textarea required id="text" rows="2" name="text" placeholder="{{ __('Your comment...') }}"
            class="resize-none w-full px-0 text-gray-950 dark:text-gray-200 bg-gray-50 border-0 dark:bg-zinc-950 focus:ring-0 dark:placeholder-gray-400"
            :value="text" @change="text = $el.value"></textarea>
        <x-input-error :messages="$errors->get('text')" />
    </div>

    <div class="flex items-center justify-between px-3 py-2 border-t dark:border-zinc-700" x-data="{ images: 0 }">
        <div class="flex ps-0 space-x-1 rtl:space-x-reverse">
            <label for="input-image-comment"
                class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                <input id="input-image-comment" name="images[]" class="hidden" type="file" accept=".png,.jpg,.jpeg"
                    multiple
                    @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')};photos = $el.files.length">
                <svg class="w-4 h-4" aria-hidden="true" fill="currentColor" viewBox="0 0 20 18">
                    <path
                        d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                </svg>
                <span class="sr-only">Upload image</span>
            </label>

            <x-dropdown align="bottom" width="auto">
                <x-slot name="trigger">
                    <button type="button" data-dropdown-placement="top"
                        class="inline-flex justify-center items-center p-2 text-gray-600 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-zinc-700">
                        <span>&#128516</span>
                        <span class="sr-only">Add emoji</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <div class="px-2 py-1 grid grid-cols-5 h-60 overflow-y-auto">
                        @include('chat.components.emoji')
                    </div>
                </x-slot>
            </x-dropdown>

            <div class="flex flex-col justify-center ml-2">
                <div class="text-xxs sm:text-xs text-gray-500" style="display: hidden" x-show="images > 0">
                    {{ __('Image') }}: <span class="text-gray-700 dark:text-gray-300" x-text="images"></span>
                </div>
            </div>
        </div>

        <button type="submit" id="send_button"
            class="inline-flex items-center py-2.5 px-4 text-xs text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-700 hover:bg-indigo-700">
            {{ __('Send') }}
        </button>
    </div>
</form>
