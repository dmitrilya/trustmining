@props(['disabled' => false, 'class' => '', 'max' => 40, 'value' => null, 'name'])

<div x-data="{ max: {{ $max }}, length: {{ mb_strlen($value) }} }"
    class="{{ $class }} flex py-1.5 px-3 block mt-1 w-full rounded-md shadow-sm shadow-logo-color text-gray-950 bg-white dark:bg-zinc-950 dark:text-gray-200 border-0 ring-1 ring-inset ring-gray-300 dark:ring-zinc-700 focus-within:ring-indigo-500 dark:focus-within:ring-indigo-500">
    <textarea name="{{ $name }}" class="w-full bg-transparent border-0 p-0 focus:outline-none focus:ring-0" {{ $disabled ? 'disabled' : '' }}
        value="{{ $value }}" {{ $attributes }}
        @input="length = $el.value.length;
            if (length > max) errors['{{ $name }}'] = '{{ __('Maximum character limit exceeded') }}';
            else delete errors['{{ $name }}'];">{{ $value }}</textarea>
    <div class="min-w-fit mt-1 ml-2 sm:ml-3 text-xxs sm:text-xs text-gray-600 dark:text-gray-400">
        <span :class="length > max ? 'text-red-500' : ''" x-text="length" x-text="length"></span>/<span
            x-text="max"></span>
    </div>
</div>
