@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm text-slate-800 dark:text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
