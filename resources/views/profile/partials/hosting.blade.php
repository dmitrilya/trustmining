<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Hosting') }}
            </h2>

            @if ($user->tariff && $user->tariff->can_have_hosting && $user->company && !$user->company->moderation)
                @if (!$user->hosting)
                    <a href="{{ route('hosting.create') }}"><x-primary-button>{{ __('Create') }}</x-primary-button></a>
                @elseif (!$user->company->moderation)
                    <a href="{{ route('hosting.edit', ['hosting' => $user->hosting->id]) }}">
                        <x-primary-button>{{ __('Edit') }}</x-primary-button>
                @endif
            @endif
        </div>
    </header>

    <div class="mt-6">
        @if ($user->tariff && $user->tariff->can_have_hosting)
            @if (!$user->company)
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
                {{ __('Not available with current plan.') }}
            </p>
        @endif
    </div>
</section>
