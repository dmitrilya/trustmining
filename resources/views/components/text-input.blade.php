@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'py-1.5 px-3 block mt-1 w-full rounded-md shadow-sm shadow-logo-color text-gray-950 bg-white dark:bg-zinc-950 dark:text-gray-200 border-0 ring-1 ring-inset focus:ring-inset ring-gray-300 dark:ring-zinc-700 focus:outline-none focus:ring-indigo-500 dark:focus:ring-indigo-500']) }}>
