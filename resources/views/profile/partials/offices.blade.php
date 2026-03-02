<section class="space-y-6">
    <header>
        <div class="flex justify-between items-center">
            <h2 class="text-lg text-slate-950 dark:text-slate-50">
                {{ __('Offices') }}
            </h2>

            @if (
                (($user->tariff && $user->offices->count() < $user->tariff->max_offices) ||
                    (!$user->tariff && $user->offices->count() < 1)) &&
                    ($user->passport || ($user->company && !$user->company->moderation)))
                <a href="{{ route('office.create') }}"
                    class="min-w-7 h-7 rounded-full shadow-lg shadow-logo-color bg-secondary-gradient opacity-70 hover:opacity-100 hover:shadow-xl shadow-logo-color text-white text-3xl flex items-center justify-center">+</a>
            @endif
        </div>
    </header>

    <div class="text-slate-500 text-sm">
        <span class="text-slate-950 dark:text-slate-50 text-xl sm:text-2xl font-bold">{{ $user->offices->count() }} /
            {{ $user->tariff ? $user->tariff->max_offices : 1 }}</span>
        {{ __('according to the tariff') }} {{ $user->tariff ? $user->tariff->name : 'Base' }}
    </div>

    @if (!$user->passport && (!$user->company || $user->company->moderation))
        <p class="text-sm text-slate-700 dark:text-slate-400">
            {{ __('Please verify your identity using your passport or register a company to add offices.') }}
        </p>
    @elseif ($user->offices->count())
        <div>
            <div class="flex justify-between">
                <p class="text-sm text-slate-700 dark:text-slate-300">
                    {{ __('Active') }}
                </p>

                <p class="text-base text-slate-700 dark:text-slate-300">
                    {{ $user->offices->where('moderation', false)->count() }}
                </p>
            </div>

            <div class="flex justify-between mt-2">
                <p class="text-sm text-slate-700 dark:text-slate-300">
                    {{ __('Is under moderation') }}
                </p>

                <p class="text-base text-slate-700 dark:text-slate-300">
                    {{ $user->offices->where('moderation', true)->count() }}
                </p>
            </div>
        </div>
    @else
        <p class="text-sm text-slate-700 dark:text-slate-400">
            {{ __('Add information about open offices and points of sale.') }}
        </p>
    @endif
</section>
