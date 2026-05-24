<x-modal name="roulette-prize-toggle-active" focusable>
    <form method="post" :action="`/roulette/prize/${selectedPrize?.id}/toggle-active`" class="p-6">
        @csrf
        @method('PUT')

        <h2 class="text-lg text-slate-950 dark:text-slate-50"
            x-text="`{{ __('Are you sure you want to') }} ${selectedPrize?.activated_at ? '{{ __('deactivate') }}' : '{{ __('activate') }}'} {{ __('the draw') }} ${selectedPrize?.name}`">
        </h2>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ml-3"
                x-text="selectedPrize?.activated_at ? '{{ __('Deactivate') }}' : '{{ __('Activate') }}'">
            </x-primary-button>
        </div>
    </form>
</x-modal>
