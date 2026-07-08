@php
    $canHavePhone = $user->tariff && $user->tariff->can_have_phone;
    $phone = $user->phones->first();
@endphp

<x-profile.section h="Phone number" :p="!$canHavePhone ? 'Not available with current plan' : null">
    @if ($canHavePhone)
        <form class="flex items-center" method="POST"
            action="{{ !$phone ? route('phone.store') : route('phone.update', ['phone' => $phone->id]) }}">
            @csrf
            @if ($phone)
                @method('PUT')
            @endif

            <div class="w-full mr-3">
                <div class="relative">
                    <span class="absolute left-2.5 top-1 text-lg">+</span>
                    <x-inputs.text-input type="tel" class="pl-6" name="number" :value="!$phone ? old('number') : $phone->number" required
                        x-mask:dynamic="$input.startsWith('7') ? '9 (999) 999-99-99' : '999999999999999'"
                        placeholder="7 (9##) ###-##-##" />
                </div>
                <x-inputs.input-error :messages="$errors->get('number')" />
            </div>

            <x-buttons.primary-button class="mt-1">{{ __('Save') }}</x-buttons.primary-button>
        </form>
    @endif
</x-profile.section>
