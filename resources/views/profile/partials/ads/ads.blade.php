@php
    $adsCount = $user->ads->count();
    $moreAdsAvailable = ($user->tariff && $adsCount < $user->tariff->max_ads) || (!$user->tariff && $adsCount < 2);
    $hasVerification = $user->passport || ($user->company && !$user->company->moderation);
    $officeExists = $user->offices->count() > 0;
@endphp

<x-profile.section h="My advertisements" :p="!$hasVerification
    ? 'Please verify your identity using your passport or register a company to access advertisements'
    : (!$officeExists
        ? 'When creating a sales ad, you will need to indicate where to pick up the equipment. So first add information about your office or point of sale'
        : null)">
    @if ($moreAdsAvailable && $hasVerification && $officeExists)
        <x-slot name="i">
            <a href="{{ route('ad.create') }}"
                class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">+</a>
        </x-slot>
    @endif

    @if ($hasVerification && $officeExists)
        <div class="text-slate-500 text-sm">
            <span class="text-slate-800 dark:text-slate-200 text-xl sm:text-2xl font-bold">{{ $adsCount }} /
                {{ $user->tariff ? $user->tariff->max_ads : 2 }}</span>
            {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
        </div>

        <x-characteristics.characteristics>
            <x-characteristics.characteristic name="Active" :value="$user->ads->where('hidden', false)->where('moderation', false)->count()" />
            <x-characteristics.characteristic name="Is under moderation" :value="$user->ads->where('moderation', true)->count()" />
            <x-characteristics.characteristic name="Hidden" :value="$user->ads->where('hidden', true)->count()" />
        </x-characteristics.characteristics>

        @if ($user->ads->where('moderation', false)->count())
            <div class="flex justify-end mt-4">
                <a href="{{ route('ad.statistics') }}">
                    <x-buttons.secondary-button class="bg-secondary-gradient dark:text-slate-800 mr-2 sm:mr-3">
                        {{ __('Statistics') }}
                    </x-buttons.secondary-button>
                </a>

                <a href="{{ route('ad.edit.mass') }}">
                    <x-buttons.primary-button>{{ __('Update prices') }}</x-buttons.primary-button>
                </a>
            </div>
        @endif
    @endif
</x-profile.section>
