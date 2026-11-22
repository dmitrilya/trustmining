@props(['name', 'title', 'clearable' => true])

<x-modal name="attach-{{ $name }}_modal" maxWidth="md">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __($title) }}
            </h3>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500" @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{ $slot }}

        <x-buttons.primary-button class="mt-2 sm:mt-4 block ml-auto" type="button"
            @click="
                show = false;
                const input = $el.previousElementSibling.querySelector('input');
                attachCallback(processVideoLink(input.value));
                {{ $clearable ? 'input.value = null;' : '' }}
                attachCallback = null;
            ">
            {{ __('Attach') }}
        </x-buttons.primary-button>
    </div>
</x-modal>
