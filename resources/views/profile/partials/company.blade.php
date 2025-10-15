<section>
    <header class="mb-2">
        <div class="flex justify-between">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Company') }}
            </h2>

            @if ($user->company && !$user->company->moderation)
                <a href="{{ route('company.edit', ['company' => $user->company->id]) }}"
                    class="min-w-7 h-7 rounded-full shadow-lg bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl text-white text-3xl flex items-center justify-center">
                    <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                    </svg>
                </a>
            @endif
        </div>
    </header>

    @if (!$user->company)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
            {{ __('Add information about your company.') }}
        </p>

        <form method="post" action="{{ route('company.store') }}" class="mt-6 space-y-6">
            @csrf

            <div>
                <x-input-label for="inn" :value="__('Company TIN')" />
                <x-text-input id="inn" name="inn" required autocomplete="inn" />
                <x-input-error :messages="$errors->get('inn')" />
            </div>

            <x-primary-button class="block ml-auto">{{ __('Confirm') }}</x-primary-button>
        </form>
    @elseif ($user->company->moderation)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
            {{ __('Make a payment to confirm ownership of the specified company.') }}
        </p>

        <a href="{{ $user->orders()->where('amount', 10)->where('status', 'NEW')->first('invoice_url')->invoice_url }}">
            <x-primary-button class="block ml-auto">{{ __('Pay') }}</x-primary-button>
        </a>
    @else
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('The company is registered. Now you can fill the About page with an additional description that reveals your values ​​and a photo.') }}
        </p>
    @endif
</section>
