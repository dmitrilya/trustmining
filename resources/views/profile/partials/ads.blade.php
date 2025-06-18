<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('My advertisements') }}
            </h2>

            @if (($user->tariff && $user->ads->count() < $user->tariff->max_ads) || (!$user->tariff && $user->ads->count() < 5))
                @if ($user->passport && !$user->passport->moderation && $user->offices()->where('moderation', false)->exists())
                    <a href="{{ route('ad.create') }}"><x-primary-button>{{ __('Create') }}</x-primary-button></a>
                @endif
            @else
                <p class="text-xs text-gray-600">
                    {{ __('Not available with current plan.') }}
                </p>
            @endif
        </div>
    </header>

    <div class="text-gray-400 text-lg">
        <span class="text-gray-900 text-xl sm:text-2xl font-bold">{{ $user->ads->count() }} /
            {{ $user->tariff ? $user->tariff->max_ads : 5 }}</span>
        {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
    </div>

    @if (!$user->passport || $user->passport->moderation)
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please verify your identity using your passport or register a company to access advertisements.') }}
        </p>
    @elseif (!$user->offices()->where('moderation', false)->exists())
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('When creating a sales ad, you will need to indicate where to pick up the equipment. So first add information about your office or point of sale.') }}
        </p>
    @else
        <div class="mt-6">
            <div class="flex justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Active') }}
                </p>

                <p class="text-base text-gray-600 dark:text-gray-400">
                    {{ $user->ads()->where('hidden', false)->where('moderation', false)->count() }}
                </p>
            </div>

            <div class="flex justify-between mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Is under moderation') }}
                </p>

                <p class="text-base text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('moderation', true)->count() }}
                </p>
            </div>

            <div class="flex justify-between mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Hidden') }}
                </p>

                <p class="text-base text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('hidden', true)->count() }}
                </p>
            </div>
        </div>
    @endif
</section>
