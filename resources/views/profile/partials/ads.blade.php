<section class="space-y-6">
    <header>
        <div class="flex justify-between">
            <h2 class="w-full text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('My advertisements') }}
            </h2>

            @if (
                (($user->tariff && $user->ads->count() < $user->tariff->max_ads) || (!$user->tariff && $user->ads->count() < 2)) &&
                    ($user->passport || ($user->company && !$user->company->moderation)) &&
                    $user->offices->count())
                <a href="{{ route('ad.create') }}"
                    class="min-w-7 h-7 rounded-full shadow-lg bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl text-white text-3xl flex items-center justify-center">+</a>
            @endif
        </div>
    </header>

    <div class="text-gray-400 text-lg">
        <span class="text-gray-900 dark:text-gray-100 text-xl sm:text-2xl font-bold">{{ $user->ads->count() }} /
            {{ $user->tariff ? $user->tariff->max_ads : 2 }}</span>
        {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
    </div>

    @if (!$user->passport && (!$user->company || $user->company->moderation))
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please verify your identity using your passport or register a company to access advertisements.') }}
        </p>
    @elseif (!$user->offices->count())
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('When creating a sales ad, you will need to indicate where to pick up the equipment. So first add information about your office or point of sale.') }}
        </p>
    @else
        <div>
            <div class="flex justify-between">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Active') }}
                </p>

                <p class="text-base text-gray-600 dark:text-gray-400">
                    {{ $user->ads->where('hidden', false)->where('moderation', false)->count() }}
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

        @if ($user->ads->where('moderation', false)->count())
            <div class="flex justify-end mt-4">
                <a href="{{ route('ad.statistics') }}">
                    <x-secondary-button class="bg-secondary-gradient !text-white mr-2 sm:mr-3">
                        {{ __('Statistics') }}
                    </x-secondary-button>
                </a>

                <a href="{{ route('ad.edit.mass') }}">
                    <x-primary-button>{{ __('Update prices') }}</x-primary-button>
                </a>
            </div>
        @endif
    @endif
</section>
