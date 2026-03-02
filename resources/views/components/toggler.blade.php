@props(['disabled' => false, 'checked' => false])

<label class="inline-flex items-center w-full cursor-pointer">
    <input type="checkbox" @change="$dispatch('toggle-checked')" class="sr-only peer"
        {{ $checked ? 'checked' : '' }} {{ $disabled ? 'disabled' : '' }} {{ $attributes }}>
    <div
        class="relative w-9 h-5 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full rtl:peer-checked:after:translate-x-[-100%] peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-700 peer-checked:bg-indigo-600">
    </div>
    <span class="ms-3 text-sm text-slate-950 dark:text-slate-200">{{ $slot }}</span>
</label>
