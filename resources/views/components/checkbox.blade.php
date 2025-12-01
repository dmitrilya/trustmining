@props([
    'class' => '',
    'disabled' => false,
    'name',
    'value',
    'checked' => false,
    'textClasses' => 'text-gray-700 dark:text-gray-200',
])

<div class="{{ $class }}">
    <label class="flex items-center cursor-pointer p-0.5">
        <input @if ($disabled) disabled @endif @if ($checked) checked @endif
            type="checkbox" name="{{ $name }}" value="{{ $value }}"
            class="mr-2 w-3 h-3 sm:w-4 sm:h-4 text-xs sm:text-sm cursor-pointer text-indigo-600 bg-gray-100 dark:bg-zinc-900 border-gray-300 dark:border-zinc-700 rounded focus:ring-0 dark:ring-offset-zinc-700">
        <p class="text-xs sm:text-sm {{ $textClasses }}">{{ $slot }}</p>
    </label>
</div>
