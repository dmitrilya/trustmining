@props([
    'class' => '',
    'disabled' => false,
    'name',
    'textClasses' => 'text-slate-800 dark:text-slate-200',
    'handleChange' => null,
    'sm' => null,
])

<div class="{{ $class }}">
    <label class="flex items-center cursor-pointer group">
        <input @if ($disabled) disabled @endif
            @if ($handleChange) @change="{{ $handleChange }}($el.value)" @endif type="radio"
            name="{{ $name }}" {{ $attributes->merge(['class' => 'sr-only peer']) }}>

        <div
            class="{{ $sm ? 'mr-1 sm:mr-2 w-3 h-3 sm:w-4 sm:h-4' : 'mr-2 w-4 h-4' }} flex items-center justify-center shrink-0 bg-slate-100 dark:bg-slate-900 peer-checked:bg-indigo-600 border border-slate-300 dark:border-slate-700 rounded-full transition-all duration-100 text-transparent peer-checked:text-white peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
            <svg class="w-1.5 h-1.5 sm:w-2 sm:h-2" viewBox="0 0 100 100" fill="currentColor">
                <circle cx="50" cy="50" r="50" />
            </svg>
        </div>

        @if ($slot->isNotEmpty())
            <p class="{{ $sm ? 'text-xxs' : 'text-xs' }} sm:text-sm {{ $textClasses }} select-none">
                {{ $slot }}
            </p>
        @endif
    </label>
</div>
