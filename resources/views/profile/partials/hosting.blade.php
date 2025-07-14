<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                    {{ __('Hosting') }}
                </h2>

                @if ($user->tariff && $user->tariff->can_have_hosting)
                    @if (!$user->company || $user->company->moderation)
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('To add information about placement, you must register a company.') }}
                        </p>
                    @elseif (!$user->hosting)
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('If you have the opportunity to host equipment, then you can indicate all the information about the hosting so that clients can see it in the company profile.') }}
                        </p>
                    @else
                        <div class="flex">
                            @if (count($user->hosting->images))
                                <img class="w-full aspect-[4/3] overflow-hidden rounded-lg mr-4"
                                    src="{{ Storage::url($user->hosting->images[0]) }}" alt="hosting_image">
                            @endif

                            <div>
                                <p class="text-xxs sm:text-sm text-gray-400">{{ __('Location') . ': ' }}<span
                                        class="text-gray-600">{{ $user->hosting->address }}</span></p>

                                <p class="text-xxs sm:text-sm text-gray-400">{{ __('Tariff') . ': ' }}<span
                                        class="text-gray-600">{{ $user->hosting->price }}</span></p>
                            </div>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Not available with current plan') }}
                    </p>
                @endif
            </div>

            @if ($user->tariff && $user->tariff->can_have_hosting && $user->company && !$user->company->moderation)
                @if (!$user->hosting)
                    <a href="{{ route('hosting.create') }}"
                        class="min-w-7 h-7 rounded-full shadow-lg bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl text-white text-3xl flex items-center justify-center">
                        +</a>
                @elseif (!$user->hosting->moderation)
                    <a href="{{ route('hosting.edit', ['hosting' => $user->hosting->id]) }}"
                        class="min-w-7 h-7 rounded-full shadow-lg bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl text-white text-3xl flex items-center justify-center">
                        <svg class="w-[1.125rem] h-[1.125rem] ml-1 mb-0.5" aria-hidden="true" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2.5"
                                d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                        </svg>
                    </a>
                @endif
            @endif
        </div>
    </header>
</section>
