@props(['name', 'value', 'textClasses' => '', 'checked'])

<div {{ $attributes }}>
    <label class="flex items-center">
        <input type="radio" name="{{ $name }}" value="{{ $value }}" @if ($checked) checked @endif
            class="mr-2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-0 dark:bg-zinc-800 dark:border-zinc-700">
        <p class="text-sm {{ $textClasses }}">{{ $slot }}</p>
    </label>
</div>
