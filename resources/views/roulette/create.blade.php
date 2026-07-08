<x-modal name="roulette-prize-create">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Create a draw') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex w-6 h-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('roulette.prize.store') }}" class="space-y-4">
            @csrf

            <x-inputs.select :label="__('Company')" name="user_id" :items="collect($users)" />

            <div>
                <x-inputs.input-label for="roulette-prize-create_name" :value="__('Title')" />
                <x-inputs.text-input id="roulette-prize-create_name" type="text" name="name" required />
                <x-inputs.input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-inputs.input-label for="roulette-prize-create_caption" :value="__('Caption')" />
                <x-inputs.text-input id="roulette-prize-create_caption" type="text" name="caption" required />
                <x-inputs.input-error :messages="$errors->get('caption')" />
            </div>

            <div>
                <x-inputs.input-label for="roulette-prize-create_partner_link" :value="__('Partner link')" />
                <x-inputs.text-input id="roulette-prize-create_partner_link" type="text" name="partner_link" required />
                <x-inputs.input-error :messages="$errors->get('partner_link')" />
            </div>

            <div>
                <x-inputs.input-label for="roulette-prize-create_href" :value="__('Take the prize')" />
                <x-inputs.text-input id="roulette-prize-create_href" type="text" name="href" required />
                <x-inputs.input-error :messages="$errors->get('href')" />
            </div>

            <div>
                <x-inputs.input-label for="roulette-prize-create_chance" :value="__('Chance')" />
                <x-inputs.text-input id="roulette-prize-create_chance" type="text" name="chance" required />
                <x-inputs.input-error :messages="$errors->get('chance')" />
            </div>

            <x-buttons.primary-button class="block ml-auto">
                {{ __('Create') }}
            </x-buttons.primary-button>
        </form>
    </div>
</x-modal>
