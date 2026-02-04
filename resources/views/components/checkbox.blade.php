@props([
    'class' => '',
    'disabled' => false,
    'name',
    'value',
    'checked' => false,
    'textClasses' => 'text-gray-700 dark:text-gray-200',
    'handleChange' => null,
    'sm' => null
])

<div class="{{ $class }}">
    <label class="flex items-center cursor-pointer p-0.5">
        <input @if ($disabled) disabled @endif @if ($checked) checked @endif
            @if ($handleChange) @change="{{ $handleChange }}($el.checked)" @endif type="checkbox"
            name="{{ $name }}" value="{{ $value }}"
            class="{{ $sm ? 'mr-1 sm:mr-2' : 'mr-2' }} w-3 h-3 sm:w-4 sm:h-4 text-xs sm:text-sm cursor-pointer text-indigo-600 bg-gray-100 dark:bg-zinc-900 border-gray-300 dark:border-zinc-700 rounded focus:ring-0 dark:ring-offset-zinc-700">
        <p class="{{ $sm ? 'text-xxs' : 'text-xs' }} sm:text-sm {{ $textClasses }}">{{ $slot }}</p>
    </label>
</div>
