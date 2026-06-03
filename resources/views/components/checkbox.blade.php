@props([
    'class' => '',
    'disabled' => false,
    'name',
    'value',
    'checked' => false,
    'textClasses' => 'text-slate-700 dark:text-slate-200',
    'handleChange' => null,
    'sm' => null,
])

<div class="{{ $class }}">
    <label class="flex items-center cursor-pointer p-0.5 group">
        <input @if ($disabled) disabled @endif @if ($checked) checked @endif
            @if ($handleChange) @change="{{ $handleChange }}($el.checked)" @endif type="checkbox"
            name="{{ $name }}" value="{{ $value }}" class="sr-only peer">
        <div
            class="{{ $sm ? 'mr-1 sm:mr-2 w-3 h-3 sm:w-4 sm:h-4' : 'mr-2 w-4 h-4' }} flex items-center justify-center shrink-0 bg-slate-100 dark:bg-slate-900 peer-checked:bg-indigo-600 border border-slate-300 dark:border-slate-700 rounded-full transition-all duration-100 text-transparent peer-checked:text-white peer-disabled:opacity-50 peer-disabled:cursor-not-allowed">
            <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <p class="{{ $sm ? 'text-xxs' : 'text-xs' }} sm:text-sm {{ $textClasses }} select-none">
            {{ $slot }}
        </p>
    </label>
</div>
