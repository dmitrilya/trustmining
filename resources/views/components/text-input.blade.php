@props(['disabled' => false, 'type' => 'text'])

@if ($type === 'password')
    <div x-data="{ show: false }" class="relative mt-1">
        <input {{ $disabled ? 'disabled' : '' }} :type="show ? 'text' : 'password'"
            {{ $attributes->merge(['class' => 'py-1.5 px-3 block w-full rounded-md shadow-sm shadow-logo-color text-slate-950 bg-white dark:bg-slate-950 dark:text-slate-200 border-0 ring-1 ring-inset focus:ring-inset ring-slate-300 dark:ring-slate-700 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-500']) }}>
        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" @click="show = !show">
            <template x-if="!show">
                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 010-.644C3.399 8.049 7.21 5 12 5c4.79 0 8.601 3.049 9.964 6.678.045.122.045.255 0 .377-1.363 3.629-5.174 6.678-9.964 6.678-4.79 0-8.601-3.049-9.964-6.678z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </template>
            <template x-if="show">
                <svg xmlns="http://w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                    class="w-5 h-5 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </template>
        </button>
    </div>
@else
    <input {{ $disabled ? 'disabled' : '' }} type="{{ $type }}"
        {{ $attributes->merge(['class' => 'py-1.5 px-3 block mt-1 w-full rounded-md shadow-sm shadow-logo-color text-slate-950 bg-white dark:bg-slate-950 dark:text-slate-200 border-0 ring-1 ring-inset focus:ring-inset ring-slate-300 dark:ring-slate-700 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-500']) }}>
@endif
