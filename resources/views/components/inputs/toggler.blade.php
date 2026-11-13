@props(['disabled' => false, 'checked' => false, 'big' => false])

<label class="inline-flex items-center w-full cursor-pointer">
    <input type="checkbox" @change="$dispatch('toggle-checked')" class="sr-only peer" {{ $checked ? 'checked' : '' }} @disabled($disabled)
        {{ $attributes }}>
    <div
        class="{{ $disabled ? 'opacity-50 ' : ''}}relative {{ $big ? 'w-11 h-6' : 'w-9 h-5' }} bg-slate-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:inset-s-0.5 after:bg-white after:border-slate-300 after:border after:rounded-full {{ $big ? 'after:h-5 after:w-5' : 'after:h-4 after:w-4' }} after:transition dark:border-slate-700 peer-checked:bg-indigo-600">
    </div>
    <span class="{{ $disabled ? 'opacity-50 ' : ''}}ml-3 text-sm text-slate-800 dark:text-slate-200">{{ $slot }}</span>
</label>
