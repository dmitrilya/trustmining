@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-slate-600 dark:text-slate-400']) }}>
    {{ $value ?? $slot }}
</label>
