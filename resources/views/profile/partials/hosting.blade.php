<section>
    <header class="mb-2">
        <div class="flex justify-between">
            <h2 class="text-lg text-gray-950 dark:text-gray-50">
                {{ __('Hosting') }}
            </h2>

            @if ($user->tariff && $user->tariff->can_have_hosting && $user->company && !$user->company->moderation)
                @if (!$user->hosting)
                    <a href="{{ route('hosting.create') }}"
                        class="min-w-7 h-7 rounded-full shadow-lg dark:shadow-zinc-800 bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl dark:shadow-zinc-800 text-white text-3xl flex items-center justify-center">
                        +</a>
                @elseif (!$user->hosting->moderation)
                    <a href="{{ route('hosting.edit', ['hosting' => $user->hosting->id]) }}"
                        class="min-w-7 h-7 rounded-full shadow-lg dark:shadow-zinc-800 bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl dark:shadow-zinc-800 text-white text-3xl flex items-center justify-center">
                        <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24" height="24"
                            fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                    </a>
                @endif
            @endif
        </div>
    </header>

    @if ($user->tariff && $user->tariff->can_have_hosting)
        @if (!$user->company || $user->company->moderation)
            <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ __('To add information about placement, you must register a company.') }}
            </p>
        @elseif (!$user->hosting)
            <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ __('If you have the opportunity to host equipment, then you can indicate all the information about the hosting so that clients can see it in the company profile.') }}
            </p>
        @else
            @if ($user->hosting->moderation)
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Is under moderation') }}
                </p>
            @endif

            <p class="text-xxs sm:text-sm text-gray-500">{{ __('Location') . ': ' }}<span
                    class="text-gray-700">{{ __($user->hosting->address) }}</span></p>

            <p class="text-xxs sm:text-sm text-gray-500">{{ __('Tariff') . ': ' }}<span
                    class="text-gray-700">{{ $user->hosting->price }}</span></p>
        @endif
    @else
        <p class="text-sm text-gray-700 dark:text-gray-300">
            {{ __('Not available with current plan') }}
        </p>
    @endif
</section>
