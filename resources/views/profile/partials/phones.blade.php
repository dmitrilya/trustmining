<section class="space-y-6">
    <header>
        <h2 class="text-lg text-gray-950 dark:text-gray-50">
            {{ __('Phone number') }}
        </h2>

        @if (!($user->tariff && $user->tariff->can_have_phone))
            <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">
                {{ __('Not available with current plan') }}
            </p>
        @endif
    </header>

    @if ($user->tariff && $user->tariff->can_have_phone)
        @php
            $phone = $user->phones->first();
        @endphp

        <form class="flex items-center" method="POST"
            action="{{ !$phone ? route('phone.store') : route('phone.update', ['phone' => $phone->id]) }}">
            @csrf
            @if ($phone)
                @method('PUT')
            @endif

            <div class="w-full mr-3">
                <div class="relative">
                    <span class="absolute left-2.5 top-1 text-lg">+</span>
                    <x-text-input type="tel" class="pl-6" name="number" :value="!$phone ? old('number') : $phone->number" required
                        x-mask:dynamic="$input.startsWith('7') ? '9 (999) 999-99-99' : '999999999999999'"
                        placeholder="7 (9##) ###-##-##" />
                </div>
                <x-input-error :messages="$errors->get('number')" />
            </div>

            <x-primary-button class="mt-1">{{ __('Save') }}</x-primary-button>
        </form>
    @endif
</section>
