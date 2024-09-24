<form @submit.prevent="sendMessage({{ $chatId }}, $el)">
    <div class="w-full border border-gray-200 rounded-b-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
        <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
            <label for="message" class="sr-only">{{ __('Your message...') }}</label>
            <textarea id="message" rows="4" name="message" placeholder="{{ __('Your message...') }}"
                class="resize-none w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400">@if (isset($message)){{ $message }}@endif</textarea>
        </div>
        <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600" x-data="{ files: 0, photos: 0 }">
            <div class="flex ps-0 space-x-1 rtl:space-x-reverse">
                <label for="input-file-chat"
                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                    <input id="input-file-chat" name="files[]" class="hidden" type="file" accept=".pdf" multiple
                        @change="if ($el.files.length > 3) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')};files = $el.files.length">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 12 20">
                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                            d="M1 6v8a5 5 0 1 0 10 0V4.5a3.5 3.5 0 1 0-7 0V13a2 2 0 0 0 4 0V6" />
                    </svg>
                    <span class="sr-only">Attach file</span>
                </label>

                <label for="input-image-chat"
                    class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                    <input id="input-image-chat" name="images[]" class="hidden" type="file" accept=".png,.jpg,.jpeg"
                        multiple
                        @change="if ($el.files.length > 10) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 10]) }}', 'error')};photos = $el.files.length">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 18">
                        <path
                            d="M18 0H2a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm4.376 10.481A1 1 0 0 1 16 15H4a1 1 0 0 1-.895-1.447l3.5-7A1 1 0 0 1 7.468 6a.965.965 0 0 1 .9.5l2.775 4.757 1.546-1.887a1 1 0 0 1 1.618.1l2.541 4a1 1 0 0 1 .028 1.011Z" />
                    </svg>
                    <span class="sr-only">Upload image</span>
                </label>

                <x-dropdown align="bottom" width="auto">
                    <x-slot name="trigger">
                        <button type="button" data-dropdown-placement="top"
                            class="inline-flex justify-center items-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-600">
                            <span>&#128516</span>
                            <span class="sr-only">Add emoji</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-2 py-1 grid grid-cols-5 h-60 overflow-y-auto">
                            <x-emoji></x-emoji>
                        </div>
                    </x-slot>
                </x-dropdown>

                <div class="flex flex-col justify-center ml-2">
                    <div class="text-xxs sm:text-xs text-gray-400" style="display: hidden" x-show="files > 0">
                        {{ __('File') }}: <span class="text-gray-600" x-text="files"></span>
                    </div>
                    <div class="text-xxs sm:text-xs text-gray-400" style="display: hidden" x-show="photos > 0">
                        {{ __('Photo') }}: <span class="text-gray-600" x-text="photos"></span>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-indigo-600 rounded-lg focus:ring-4 focus:ring-indigo-200 hover:bg-indigo-700">
                {{ __('Send') }}
            </button>
        </div>
    </div>
</form>
