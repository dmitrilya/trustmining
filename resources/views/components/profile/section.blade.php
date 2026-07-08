@props(['h', 'p' => null])

<section class="space-y-6">
    <header>
        <div class="flex justify-between">
            <h2 class="font-extrabold text-lg text-slate-800 dark:text-slate-200">{{ __($h) }}</h2>

            @if (isset($i))
                {{ $i }}
            @endif
        </div>

        @if ($p)
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">{{ __($p) }}</p>
        @endif
    </header>

    {{ $slot }}
</section>
