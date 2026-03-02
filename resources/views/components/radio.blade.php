@props(['name', 'value', 'textClasses' => '', 'checked'])

<div {{ $attributes }}>
    <label class="flex items-center">
        <input type="radio" name="{{ $name }}" value="{{ $value }}" @if ($checked) checked @endif
            class="mr-2 w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 focus:ring-0 dark:bg-slate-800 dark:border-slate-700">
        <p class="text-sm {{ $textClasses }}">{{ $slot }}</p>
    </label>
</div>
