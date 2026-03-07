@props(['name', 'max' => null])

<input type="file" name="{{ $name }}"
    @change="if (typeof validation !== 'undefined' && validation['{{ $name }}']) delete validation['{{ $name }}'];
    @if ($max) if ($el.files.length > {{ $max }}) {$el.value=null;return pushToastAlert('{{ __('validation.max.array', ['max' => 3]) }}', 'error')} @endif"
    {{ $attributes->merge(['class' => 'block w-full text-xs xs:text-sm text-slate-950 shadow-sm shadow-logo-color rounded-md cursor-pointer bg-slate-50 dark:text-slate-300 dark:bg-slate-900 dark:placeholder-slate-400 border-0 ring-1 ring-inset focus:ring-inset ring-slate-300 dark:ring-slate-700 focus:outline-none focus:ring-indigo-500']) }}>
