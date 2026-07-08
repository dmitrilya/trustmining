<x-modal name="roulette-prize-toggle-active" focusable>
    <form method="post" :action="`/roulette/prize/${selectedPrize?.id}/toggle-active`" class="p-6">
        @csrf
        @method('PUT')

        <h2 class="text-lg text-slate-800 dark:text-slate-200"
            x-text="`{{ __('Are you sure you want to') }} ${selectedPrize?.activated_at ? '{{ __('deactivate') }}' : '{{ __('activate') }}'} {{ __('the draw') }} ${selectedPrize?.name}`">
        </h2>

        <div class="mt-6 flex justify-end">
            <x-buttons.secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-buttons.secondary-button>

            <x-buttons.primary-button class="ml-3"
                x-text="selectedPrize?.activated_at ? '{{ __('Deactivate') }}' : '{{ __('Activate') }}'">
            </x-buttons.primary-button>
        </div>
    </form>
</x-modal>
