@php
    $officesCount = $user->offices->count();
    $moreOfficesAvailable =
        ($user->tariff && $officesCount < $user->tariff->max_offices) || (!$user->tariff && $officesCount < 1);
    $hasVerification = $user->passport || ($user->company && !$user->company->moderation);
@endphp

<x-profile.section h="Offices" :p="!$hasVerification
    ? 'Please verify your identity using your passport or register a company to add offices'
    : (!$officesCount
        ? 'Add information about open offices and points of sale'
        : null)">
    @if ($moreOfficesAvailable && $hasVerification)
        <x-slot name="i">
            <a href="{{ route('office.create') }}"
                class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">+</a>
        </x-slot>
    @endif

    @if ($officesCount)
        <div class="text-slate-500 text-sm">
            <span class="text-slate-800 dark:text-slate-200 text-xl sm:text-2xl font-bold">{{ $officesCount }} /
                {{ $user->tariff ? $user->tariff->max_offices : 1 }}</span>
            {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
        </div>

        <x-characteristics.characteristics>
            <x-characteristics.characteristic name="Active" :value="$user->offices->where('moderation', false)->count()" />
            <x-characteristics.characteristic name="Is under moderation" :value="$user->offices->where('moderation', true)->count()" />
        </x-characteristics.characteristics>
    @endif
</x-profile.section>
