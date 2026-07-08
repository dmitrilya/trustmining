<x-profile.section h="Company" :p="!$user->company
    ? 'Add information about your company'
    : ($user->company->moderation
        ? 'Make a payment to confirm ownership of the specified company'
        : 'The company is registered. Now you can fill the About page with an additional description that reveals your values ​​and a photo')">
    @if ($user->company && !$user->company->moderation)
        <x-slot name="i">
            <a href="{{ route('company.edit', ['company' => $user->company->id]) }}"
                class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">
                <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                </svg>
            </a>
        </x-slot>
    @endif

    @if (!$user->company)
        <form method="post" action="{{ route('company.store') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-inputs.input-label for="inn" :value="__('Company TIN')" />
                <x-inputs.text-input id="inn" name="inn" required autocomplete="inn" />
                <x-inputs.input-error :messages="$errors->get('inn')" />
            </div>

            <x-buttons.primary-button class="block ml-auto">{{ __('Confirm') }}</x-buttons.primary-button>
        </form>
    @elseif (
        $user->company->moderation &&
            ($order = $user->orders()->where('amount', 10)->where('status', 'init')->latest()->first('invoice_url')))
        <a href="{{ $order->invoice_url }}" target="_blank">
            <x-buttons.primary-button class="block ml-auto">{{ __('Pay') }}</x-buttons.primary-button>
        </a>
    @endif
</x-profile.section>
