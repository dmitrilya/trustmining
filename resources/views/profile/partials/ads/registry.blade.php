@php
    $p = !$user->registry
        ? 'Send a confirmation to the support manager and receive the "Mining operator" badge, as well as additional Trust points'
        : 'You have confirmed the operator\'s status';
@endphp

<x-profile.section h="Are you a member of the mining registry?" :p="$p">
    @if (!$user->registry)
        <a class="block w-fit ml-auto mt-3 xs:mt-4 sm:mt-5"
            href="{{ route('support', ['tab' => 'chat', 'message' => __('Hello! Our company is a member of the register of mining operators. We will send the confirmation now')]) }}">
            <x-buttons.secondary-button
                class="bg-secondary-gradient dark:text-slate-800">{{ __('Contact') }}</x-buttons.secondary-button>
        </a>
    @endif
</x-profile.section>
