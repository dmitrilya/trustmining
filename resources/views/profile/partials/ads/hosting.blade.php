@php
    $canHaveHosting = $user->tariff && $user->tariff->can_have_hosting;
    $companyModerated = $user->company && !$user->company->moderation;
@endphp

<x-profile.section h="Hosting" :p="!$canHaveHosting
    ? 'Not available with current plan'
    : (!$companyModerated
        ? 'To add information about placement, you must register a company'
        : (!$user->hosting
            ? 'If you have the opportunity to host equipment, then you can indicate all the information about the hosting so that clients can see it in the company profile'
            : ($user->hosting->moderation
                ? 'Is under moderation'
                : 'The hosting information has been successfully posted. You can edit it')))">
    @if ($canHaveHosting && $companyModerated)
        <x-slot name="i">
            @if (!$user->hosting)
                <a href="{{ route('hosting.create') }}"
                    class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">
                    +</a>
            @elseif (!$user->hosting->moderation)
                <a href="{{ route('hosting.edit', ['hosting' => $user->hosting->id]) }}"
                    class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-80 hover:opacity-100 hover:shadow-lg shadow-logo-color text-white text-3xl flex items-center justify-center">
                    <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24" height="24"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                    </svg>
                </a>
            @endif
        </x-slot>
    @endif
</x-profile.section>
