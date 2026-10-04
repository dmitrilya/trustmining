@props(['name'])

<div id="editor-wrap"
    {{ $attributes->merge(['class' => 'bg-slate-100 dark:bg-slate-950 rounded-lg border border-slate-300 dark:border-slate-700 focus-within:ring-1 focus-within:ring-indigo-500 dark:focus-within:ring-emerald-500/50 shadow shadow-logo-color']) }}>
    <div id="editor" class="text-xs xs:text-sm sm:text-base text-slate-800 dark:text-slate-200 focus:outline-0 p-4">
    </div>

    <input type="hidden" class="hidden" name="{{ $name }}" :value="{{ $name }}" required>
</div>
