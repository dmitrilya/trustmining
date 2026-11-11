@php
    $hostingsCount = $user->hostings()->count();
    $canCreateHosting = $user->tariff && $hostingsCount < $user->tariff->max_hostings;
@endphp

<x-profile.section h="Hosting" :p="!$canCreateHosting
    ? 'Not available with current plan'
    : (!$user->hosting
        ? 'If you have the opportunity to host equipment, then you can indicate all the information about the hosting so that clients can see it in the company profile'
        : ($user->hosting->moderation
            ? 'Is under moderation'
            : null))">
    @if ($canCreateHosting)
        <x-slot name="i">
            <a href="{{ route('hosting.create') }}"
                class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 text-white text-3xl flex items-center justify-center">
                +
            </a>
        </x-slot>

        <div class="text-slate-500 text-sm">
            <span class="text-slate-800 dark:text-slate-200 text-xl sm:text-2xl font-bold">
                {{ $hostingsCount }} / {{ $user->tariff->max_hostings }}</span>
            {{ __('according to the tariff') }} {{ $user->tariff->name }}
        </div>
    @endif
</x-profile.section>
