<button type="button"
    @click="$dispatch('open-modal', 'create-question-link' );link_text=prepareLink(range, $refs.editor)"
    class="min-w-6 h-6 sm:min-w-7 sm:h-7 text-xs sm:text-base flex justify-center items-center rounded-full bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-100">
    <svg class="size-4" aria-hidden="true" width="24" height="24" fill="none" viewBox="0 0 24 24">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M13.213 9.787a3.391 3.391 0 0 0-4.795 0l-3.425 3.426a3.39 3.39 0 0 0 4.795 4.794l.321-.304m-.321-4.49a3.39 3.39 0 0 0 4.795 0l3.424-3.426a3.39 3.39 0 0 0-4.794-4.795l-1.028.961" />
    </svg>
</button>

<x-modal name="create-question-link" maxWidth="sm">
    <div class="p-4">
        <h3 class="text-lg text-slate-950 dark:text-slate-50 mb-6">
            {{ __('Create link') }}
        </h3>

        <div class="relative z-0 w-full mb-5 group">
            <input type="text" id="hyper" placeholder=" " :value="link_text" @change="link_text = $el.value"
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
            <label for="hyper"
                class="absolute text-sm text-slate-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                {{ __('Text') }}
            </label>
        </div>

        <div class="relative z-0 w-full mb-5 group">
            <input type="url" id="url" placeholder=" " :value="link_url" @change="link_url = $el.value"
                class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-slate-700 dark:text-slate-300 border-slate-300 dark:border-slate-700 focus:border-indigo-500 focus:outline-none focus:ring-0 peer" />
            <label for="url"
                class="absolute text-sm text-slate-500 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-indigo-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                URL
            </label>
        </div>

        <div class="mt-2 sm:mt-4 flex justify-end">
            <x-secondary-button @click="$dispatch('close')" class="mr-2 sm:mr-3">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button type="button"
                @click="() => {insertLink(range, $refs.editor, link_text, link_url);$dispatch('close')}">{{ __('Save') }}</x-primary-button>
        </div>
    </div>
</x-modal>
