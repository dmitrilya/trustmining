<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Offices') }}
            </h2>

            @if (
                (($user->tariff && $user->offices->count() < $user->tariff->max_offices) ||
                    (!$user->tariff && $user->offices->count() < 1)) &&
                    $user->passport)
                <a href="{{ route('office.create') }}"
                    class="min-w-7 h-7 rounded-full shadow-lg bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl text-white text-3xl flex items-center justify-center">+</a>
            @endif
        </div>
    </header>

    <div class="text-gray-400 text-lg">
        <span class="text-gray-900 dark:text-gray-100 text-xl sm:text-2xl font-bold">{{ $user->offices->count() }} /
            {{ $user->tariff ? $user->tariff->max_offices : 1 }}</span>
        {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
    </div>

    @if (!$user->passport)
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Please verify your identity using your passport or register a company to add offices.') }}
        </p>
    @elseif ($user->offices->count())
        <div class="flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Active') }}
            </p>

            <p class="text-base text-gray-600 dark:text-gray-400">
                {{ $user->offices->where('moderation', false)->count() }}
            </p>
        </div>

        <div class="flex justify-between">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('Is under moderation') }}
            </p>

            <p class="text-base text-gray-600 dark:text-gray-400">
                {{ $user->offices->where('moderation', true)->count() }}
            </p>
        </div>
    @else
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Add information about open offices and points of sale.') }}
        </p>
    @endif
</section>
