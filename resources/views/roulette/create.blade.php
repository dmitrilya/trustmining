<x-modal name="roulette-prize-create">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg text-slate-800 dark:text-slate-200">
                {{ __('Create a draw') }}
            </h2>

            <button type="button" aria-label="{{ __('Close') }}"
                class="ml-4 flex size-6 items-center justify-center rounded-md bg-white dark:bg-slate-950 text-slate-500"
                @click="show = false">
                <span class="sr-only">Close</span>
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('roulette.prize.store') }}" class="space-y-4">
            @csrf

            <x-select :label="__('Company')" name="user_id" :items="collect($users)" />

            <div>
                <x-input-label for="roulette-prize-create_name" :value="__('Title')" />
                <x-text-input id="roulette-prize-create_name" type="text" name="name" required />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="roulette-prize-create_caption" :value="__('Caption')" />
                <x-text-input id="roulette-prize-create_caption" type="text" name="caption" required />
                <x-input-error :messages="$errors->get('caption')" />
            </div>

            <div>
                <x-input-label for="roulette-prize-create_partner_link" :value="__('Partner link')" />
                <x-text-input id="roulette-prize-create_partner_link" type="text" name="partner_link" required />
                <x-input-error :messages="$errors->get('partner_link')" />
            </div>

            <div>
                <x-input-label for="roulette-prize-create_href" :value="__('Take the prize')" />
                <x-text-input id="roulette-prize-create_href" type="text" name="href" required />
                <x-input-error :messages="$errors->get('href')" />
            </div>

            <div>
                <x-input-label for="roulette-prize-create_chance" :value="__('Chance')" />
                <x-text-input id="roulette-prize-create_chance" type="text" name="chance" required />
                <x-input-error :messages="$errors->get('chance')" />
            </div>

            <x-primary-button class="block ml-auto">
                {{ __('Create') }}
            </x-primary-button>
        </form>
    </div>
</x-modal>
