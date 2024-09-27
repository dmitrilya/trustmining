@props(['class' => '', 'disabled' => false, 'name', 'value', 'checked' => false, 'textClasses' => 'text-gray-700 dark:text-gray-300'])

<div class="{{ $class }}">
    <label class="flex items-center">
        <input @if ($disabled) disabled @endif @if ($checked) checked @endif @change="$el.form.submit()"
            type="checkbox" name="{{ $name }}" value="{{ $value }}"
            class="mr-2 w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-0">
        <p class="text-sm {{ $textClasses }}">{{ $slot }}</p>
    </label>
</div>
