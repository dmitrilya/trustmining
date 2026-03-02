@props(['disabled' => false, 'class' => '', 'max' => 40, 'value' => null, 'name', 'regex' => null])

<div x-data="{ max: {{ $max }}, length: {{ mb_strlen($value) }} }"
    class="{{ $class }} flex items-center py-1.5 px-3 block mt-1 w-full rounded-md shadow-sm shadow-logo-color text-slate-950 bg-white dark:bg-slate-950 dark:text-slate-200 border-0 ring-1 ring-inset ring-slate-300 dark:ring-slate-700 focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500">
    <input name="{{ $name }}" class="w-full bg-transparent border-0 p-0 focus:outline-none focus:ring-0"
        {{ $disabled ? 'disabled' : '' }} value="{{ $value }}" {{ $attributes }}
        @input="@if ($regex) $el.value = $el.value.toLowerCase().replace({!! $regex !!}, ''); @endif
            length = $el.value.length;
            if (length > max) errors['{{ $name }}'] = '{{ __('Maximum character limit exceeded') }}';
            else delete errors['{{ $name }}'];">
    <div class="min-w-fit ml-2 sm:ml-3 text-xxs sm:text-xs text-slate-600 dark:text-slate-400">
        <span :class="length > max ? 'text-red-500' : ''" x-text="length" x-text="length"></span>/<span
            x-text="max"></span>
    </div>
</div>
