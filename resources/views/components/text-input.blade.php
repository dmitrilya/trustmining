@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => 'py-1.5 px-3 block mt-1 w-full rounded-md shadow-sm text-gray-900 bg-white dark:bg-gray-900 dark:text-gray-300 border-0 ring-1 ring-inset focus:ring-inset ring-gray-300 focus:outline-none focus:ring-indigo-500']) }}>
