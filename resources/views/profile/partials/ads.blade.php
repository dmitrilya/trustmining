<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('My advertisements') }}
            </h2>

            @if ($user->passport && !$user->passport->moderation && $user->offices()->where('moderation', false)->exists())
                <a href="{{ route('ads.create') }}"><x-primary-button>{{ __('Create') }}</x-primary-button></a>
            @endif
        </div>
    </header>

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

                <p class="text-md text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('hidden', false)->where('moderation', false)->count() }}
                </p>
            </div>

            <div class="flex justify-between mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Is under moderation') }}
                </p>

                <p class="text-md text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('moderation', true)->count() }}
                </p>
            </div>

            <div class="flex justify-between mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Hidden') }}
                </p>

                <p class="text-md text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('hidden', true)->count() }}
                </p>
            </div>
        </div>
    @endif
</section>
