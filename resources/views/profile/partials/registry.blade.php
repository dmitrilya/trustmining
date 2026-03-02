<section class="space-y-6">
    <header>
        <h2 class="text-lg text-slate-950 dark:text-slate-50 mb-2">
            {{ __('Are you a member of the mining registry?') }}
        </h2>

        @if (!$user->registry)
            <p class="text-sm text-slate-700 dark:text-slate-400">
                {{ __('Send a confirmation to the support manager and receive the "Mining operator" badge, as well as additional Trust points') }}
            </p>
        @else
            <p class="text-sm text-slate-700 dark:text-slate-400">
                {{ __('You have confirmed the operator\'s status') }}
            </p>
        @endif
    </header>

    @if (!$user->registry)
        <a class="block w-fit ml-auto mt-3 xs:mt-4 sm:mt-5"
            href="{{ route('support', ['tab' => 'chat', 'message' => __('Hello! Our company is a member of the register of mining operators. We will send the confirmation now')]) }}">
            <x-secondary-button class="bg-secondary-gradient dark:text-slate-800">{{ __('Contact') }}</x-secondary-button>
        </a>
    @endif
</section>
